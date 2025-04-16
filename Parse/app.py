import subprocess
import sys

# Auto-install packages if not found
required_packages = ['selenium', 'webdriver-manager', 'beautifulsoup4', 'requests', 'pandas', 'openpyxl']
for pkg in required_packages:
    try:
        __import__(pkg.replace('-', '_'))
    except ImportError:
        subprocess.check_call([sys.executable, "-m", "pip", "install", pkg])

# Now continue with the actual imports
import re
import requests
import pandas as pd
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from webdriver_manager.chrome import ChromeDriverManager
from bs4 import BeautifulSoup
import time
import json
import os

# Set up the Selenium WebDriver
options = webdriver.ChromeOptions()
options.add_argument('--headless')  # Run headless Chrome
options.add_argument('--no-sandbox')
options.add_argument('--disable-dev-shm-usage')

# Initialize the WebDriver
print("Setting up the web driver...")
driver = webdriver.Chrome(service=Service(ChromeDriverManager().install()), options=options)

def get_lot_data(lot_id):
    """Fetch data for a specific lot using its ID"""
    lot_link = f"https://e-auksion.uz/lot-view?lot_id={lot_id}"
    print(f"Processing lot ID: {lot_id}, URL: {lot_link}")

    try:
        driver.get(lot_link)
        # Wait for the page to load
        WebDriverWait(driver, 15).until(
            EC.presence_of_element_located((By.CSS_SELECTOR, "div.lot-main-details"))
        )

        # Get page source and parse with BeautifulSoup
        web_content = driver.page_source
        soup = BeautifulSoup(web_content, 'html.parser')

        # Initialize lot data dictionary
        lot_data = {'lot_number': lot_id, 'lot_link': lot_link}

        # Parse main image
        image_div = soup.select_one('div.q-img__image')
        if image_div:
            style = image_div.get('style', '')
            if 'background-image:' in style:
                lot_data['main_image'] = style.split('background-image: url("')[1].split('");')[0]

        # Extract lot name
        lot_name = soup.select_one('h5.q-mt-none.text-weight-bold')
        if lot_name:
            lot_data['property_name'] = lot_name.text.strip()

        # Extract and parse starting price
        starting_price_section = soup.select_one('div.row.q-col-gutter-md div.col-md-6.col-xs-12')
        if starting_price_section:
            starting_price_text = starting_price_section.text
            if 'Boshlang\'ich narxi:' in starting_price_text:
                price_text = starting_price_text.split('Boshlang\'ich narxi:')[1].strip().split('\n')[0]
                cleaned_value = re.sub(r'[^0-9.]', '', price_text)
                if cleaned_value:
                    try:
                        lot_data['start_price'] = float(cleaned_value)
                    except ValueError:
                        lot_data['start_price'] = None

        # Extract deposit amount
        if starting_price_section:
            deposit_text = starting_price_section.text
            if 'Zakalat puli miqdori:' in deposit_text:
                deposit_text = deposit_text.split('Zakalat puli miqdori:')[1].strip().split('\n')[0]
                cleaned_value = re.sub(r'[^0-9.]', '', deposit_text)
                if cleaned_value:
                    try:
                        lot_data['zakalad_amount'] = float(cleaned_value)
                    except ValueError:
                        lot_data['zakalad_amount'] = None

        # Extract auction time
        auction_time_div = soup.select_one("div.col-md-6.col-xs-12:-soup-contains('Savdo vaqti:')")
        if auction_time_div:
            auction_time_text = auction_time_div.text
            if 'Savdo vaqti:' in auction_time_text:
                lot_data['auction_date'] = auction_time_text.split('Savdo vaqti:')[1].strip().split('\n')[0]

        # Extract application deadline
        application_deadline_div = soup.select_one("div.col-md-6.col-xs-12:-soup-contains('Arizalarni qabul qilishning oxirgi muddati:')")
        if application_deadline_div:
            deadline_text = application_deadline_div.text
            if 'Arizalarni qabul qilishning oxirgi muddati:' in deadline_text:
                lot_data['application_deadline'] = deadline_text.split('Arizalarni qabul qilishning oxirgi muddati:')[1].strip().split('\n')[0]

        # Extract address information
        address_div = soup.select_one("div.col-md-6.col-xs-12:-soup-contains('Manzil:')")
        if address_div:
            address_text = address_div.text
            if 'Manzil:' in address_text:
                address_value = address_text.split('Manzil:')[1].strip().split('\n')[0]
                address_parts = address_value.split(', ')
                if len(address_parts) >= 2:
                    lot_data['region'] = address_parts[0]
                    if len(address_parts) >= 3:
                        lot_data['area'] = address_parts[1]
                        lot_data['address'] = ', '.join(address_parts[2:])
                    else:
                        lot_data['address'] = address_parts[1]

        # Extract detailed information from the table
        for row in soup.select('table.q-table tr'):
            cells = row.select('td')
            if len(cells) >= 2:
                header = cells[0].text.strip()
                value = cells[1].text.strip()

                if 'Yer uchastkasining maydoni (ga)' in header:
                    lot_data['land_area'] = value
                elif 'Mazkur yer uchastkasida qurilishga ruxsat berilgan ob\'ektlar turlari ro\'yxati' in header:
                    lot_data['build_types'] = value
                elif 'Yer uchastkasiga bo`lgan huquq turi' in header:
                    lot_data['law_type'] = value

        # Extract map coordinates
        map_link = soup.select_one("a[target='_blank'][href*='maps.google.com/?q=']")
        if map_link:
            coords_param = map_link.get('href').split('q=')[1] if 'q=' in map_link.get('href') else ''
            coords = coords_param.split(',')
            if len(coords) == 2:
                lot_data['lat'] = coords[0]
                lot_data['lng'] = coords[1]

        # Extract winner information if available
        winner_info = soup.select_one("div.lot-card.bg-white:-soup-contains('G'olib haqida ma'lumot')")
        if winner_info:
            winner_rows = winner_info.select('div.row')
            for row in winner_rows:
                row_text = row.text.strip()
                if 'G\'olib nomi:' in row_text:
                    lot_data['winner_name'] = row_text.split('G\'olib nomi:')[1].strip()
                elif 'G\'olib narxi:' in row_text:
                    price_text = row_text.split('G\'olib narxi:')[1].strip()
                    cleaned_value = re.sub(r'[^0-9.]', '', price_text)
                    if cleaned_value:
                        try:
                            lot_data['winner_amount'] = float(cleaned_value)
                        except ValueError:
                            lot_data['winner_amount'] = None

        # Additional fixed fields
        lot_data.update({
            "property_group": "Yer uchastkalari",
            "property_category": "Tadbirkorlik va shaharsozlik uchun",
            "lot_status": soup.select_one("div.lot-card.bg-white div.text-primary").text.strip() if soup.select_one("div.lot-card.bg-white div.text-primary") else "Unknown",
            "payment_type": "Muddatli bo'lib to'lash"
        })

        return lot_data

    except Exception as e:
        print(f"Error processing lot ID {lot_id}: {str(e)}")
        return {'lot_number': lot_id, 'error': str(e)}

def update_excel_with_lot_data(excel_path):
    # Load the Excel file
    print(f"Loading Excel file: {excel_path}")
    df = pd.read_excel(excel_path)

    # Check if "Лот рақами" column exists
    if "Лот рақами" not in df.columns:
        print("Error: 'Лот рақами' column not found in the Excel file.")
        return

    # Define new columns to add if they don't exist
    new_columns = [
        'lot_link', 'main_image', 'property_name', 'property_group',
        'property_category', 'lot_status', 'land_area', 'build_types',
        'law_type', 'zakalad_amount', 'application_deadline',
        'lat', 'lng', 'winner_name', 'winner_amount'
    ]

    # Add new columns if they don't exist
    for col in new_columns:
        if col not in df.columns:
            df[col] = None

    # Process each lot in the Excel file
    total_lots = len(df)
    print(f"Found {total_lots} lots in the Excel file.")

    for index, row in df.iterrows():
        lot_id = str(row["Лот рақами"]).strip()
        if not lot_id or pd.isna(lot_id):
            print(f"Skipping row {index+1}: Empty lot number")
            continue

        print(f"Processing row {index+1}/{total_lots}: Lot ID {lot_id}")
        lot_data = get_lot_data(lot_id)

        # Update the row with scraped data
        for col in new_columns:
            if col in lot_data:
                df.at[index, col] = lot_data[col]

        # Save progress after each lot (in case of interruption)
        if (index + 1) % 5 == 0 or index == total_lots - 1:
            temp_path = excel_path.replace('.xlsx', '_updated.xlsx')
            df.to_excel(temp_path, index=False)
            print(f"Progress saved at row {index+1}")

    # Save the final updated Excel file
    output_path = excel_path.replace('.xlsx', '_updated.xlsx')
    df.to_excel(output_path, index=False)
    print(f"Excel file updated successfully: {output_path}")

    return output_path

# Path to the Excel file
excel_file_path = '2024_data.xlsx'

try:
    # Update Excel with scraped data
    updated_file = update_excel_with_lot_data(excel_file_path)
    print(f"Process completed. Updated file saved as: {updated_file}")
except Exception as e:
    print(f"An error occurred: {str(e)}")
finally:
    # Close the WebDriver
    driver.quit()
    print("WebDriver closed.")
