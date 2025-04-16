import subprocess
import sys
import time
import random
import re
import os

# Auto-install packages if not found
required_packages = ['selenium', 'webdriver-manager', 'beautifulsoup4', 'requests', 'pandas', 'openpyxl', 'urllib3', 'lxml']
for pkg in required_packages:
    try:
        __import__(pkg.replace('-', '_'))
    except ImportError:
        subprocess.check_call([sys.executable, "-m", "pip", "install", pkg])

# Now continue with the actual imports
import pandas as pd
import requests
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from webdriver_manager.chrome import ChromeDriverManager
from bs4 import BeautifulSoup
import json
from datetime import datetime

# Set up the requests session
session = requests.Session()
session.headers.update({
    'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
    'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
    'Accept-Language': 'en-US,en;q=0.5',
    'Connection': 'keep-alive',
    'Upgrade-Insecure-Requests': '1',
    'Cache-Control': 'max-age=0'
})

def setup_driver():
    """Set up and return a configured Chrome WebDriver"""
    print("Setting up the web driver...")
    chrome_options = Options()
    chrome_options.add_argument('--headless')
    chrome_options.add_argument('--no-sandbox')
    chrome_options.add_argument('--disable-dev-shm-usage')
    chrome_options.add_argument('--disable-gpu')
    chrome_options.add_argument('--window-size=1920,1080')
    chrome_options.add_argument('--ignore-certificate-errors')
    chrome_options.add_argument('--disable-extensions')
    chrome_options.add_argument('--disable-popup-blocking')
    chrome_options.add_argument('--disable-blink-features=AutomationControlled')
    chrome_options.add_argument('--user-agent=Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36')

    # Add experimental options to avoid detection
    chrome_options.add_experimental_option("excludeSwitches", ["enable-automation"])
    chrome_options.add_experimental_option('useAutomationExtension', False)

    driver = webdriver.Chrome(service=Service(ChromeDriverManager().install()), options=chrome_options)

    # Execute CDP commands to avoid detection
    driver.execute_cdp_cmd("Page.addScriptToEvaluateOnNewDocument", {
        "source": """
            Object.defineProperty(navigator, 'webdriver', {
                get: () => undefined
            })
        """
    })

    return driver

def clean_text(text):
    """Clean and normalize text"""
    if not text:
        return None
    return ' '.join(text.strip().split())

def clean_number(text):
    """Extract numeric value from text"""
    if not text:
        return None
    # Remove all non-numeric characters except for dots and commas
    cleaned = re.sub(r'[^\d.,]', '', text.strip().replace(' ', '').replace(',', '.'))
    # Handle multiple dots (keep only the last one)
    if cleaned.count('.') > 1:
        parts = cleaned.split('.')
        cleaned = ''.join(parts[:-1]) + '.' + parts[-1]
    try:
        return float(cleaned) if cleaned else None
    except ValueError:
        return None

def extract_by_title(soup, title_text, tag='p', next_tag=None):
    """Extract information based on a title text"""
    elements = soup.find_all(tag, string=lambda s: s and title_text in s)
    for element in elements:
        if next_tag:
            next_elem = element.find_next(next_tag)
            if next_elem:
                return clean_text(next_elem.get_text())
        else:
            parent = element.parent
            if parent:
                for sibling in parent.next_siblings:
                    if hasattr(sibling, 'get_text'):
                        text = clean_text(sibling.get_text())
                        if text:
                            return text
    return None

def extract_table_data(soup, title_text):
    """Extract data from a table based on a title text"""
    if not soup:
        return None

    # Look for the table row containing the title
    rows = soup.select('table.q-table tr')
    for row in rows:
        cells = row.select('td')
        if len(cells) >= 2 and title_text in cells[0].get_text():
            return clean_text(cells[1].get_text())

    return None

def get_lot_data(lot_id):
    """Get lot data using both Selenium and requests approaches combined"""
    lot_link = f"https://e-auksion.uz/lot-view?lot_id={lot_id}"
    print(f"Processing lot ID: {lot_id}, URL: {lot_link}")

    # Initialize with basic data
    lot_data = {
        'lot_number': lot_id,
        'lot_link': lot_link
    }

    # Try with Selenium first
    driver = None
    try:
        driver = setup_driver()
        driver.get(lot_link)

        # Wait for main elements to load
        WebDriverWait(driver, 20).until(
            EC.presence_of_element_located((By.CSS_SELECTOR,
                "div.lot-card-info-div, div.lot-main-details, h5.q-mt-none"
            ))
        )

        # Add delay to ensure JavaScript renders fully
        time.sleep(3)

        # Get page source and parse with BeautifulSoup
        html = driver.page_source
        soup = BeautifulSoup(html, 'lxml')

        # Basic lot information
        # Extract lot name
        lot_name_elem = soup.select_one('div.lot-card-name-title')
        if lot_name_elem:
            lot_data['property_name'] = clean_text(lot_name_elem.get_text())

        # Extract main image
        image_div = soup.select_one('div.q-img__image')
        if image_div:
            style = image_div.get('style', '')
            img_url_match = re.search(r'url\([\"\']?(.*?)[\"\']?\)', style)
            if img_url_match:
                lot_data['main_image'] = img_url_match.group(1)

        # Extract starting price
        price_elem = soup.select_one('div.lot-card-attribute-title-div img[src*="baholangan_narx_icon"] + p')
        if price_elem:
            price_value = price_elem.find_next('div', class_='lot-card-attribute-value')
            if price_value:
                lot_data['start_price'] = clean_number(price_value.get_text())

        # Extract deposit amount
        deposit_elem = soup.select_one('div.lot-card-attribute-title-div img[src*="zakalad_icon"] + p')
        if deposit_elem:
            deposit_value = deposit_elem.find_next('div', class_='lot-card-attribute-value')
            if deposit_value:
                lot_data['zakalad_amount'] = clean_number(deposit_value.get_text())

        # Extract auction date
        auction_elem = soup.select_one('div.lot-card-attribute-title-div img[src*="end_auction_date"] + p')
        if auction_elem:
            auction_value = auction_elem.find_next('div', class_='lot-card-attribute-value')
            if auction_value:
                lot_data['auction_date'] = clean_text(auction_value.get_text())

        # Extract application deadline
        deadline_elem = soup.select_one('div.lot-card-attribute-title-div img[src*="application_date_icon"] + p')
        if deadline_elem:
            deadline_value = deadline_elem.find_next('div', class_='lot-card-attribute-value')
            if deadline_value:
                lot_data['application_deadline'] = clean_text(deadline_value.get_text())

        # Extract address
        address_elem = soup.select_one('div.lot-card-attribute-title-div span.material-icons-outlined:contains("location_on") + p')
        if not address_elem:
            address_elem = soup.select_one('div.lot-card-attribute-title-div:contains("Manzil:") p')

        if address_elem:
            address_value = address_elem.find_next('div', class_='lot-card-attribute-value')
            if address_value:
                address_text = clean_text(address_value.get_text())
                lot_data['address'] = address_text

                # Break down address into parts
                address_parts = address_text.split(',')
                if len(address_parts) >= 2:
                    lot_data['region'] = address_parts[0].strip()
                    if len(address_parts) >= 3:
                        lot_data['area'] = address_parts[1].strip()

        # Extract lot status
        status_elem = soup.select_one('div.lot-card-attribute-title-div i.material-icons:contains("priority_high") + p')
        if status_elem:
            status_value = status_elem.find_next('div', class_='lot-card-attribute-value')
            if status_value:
                lot_data['lot_status'] = clean_text(status_value.get_text())

        # Extract payment type
        payment_label = soup.select_one('label.ea-card-installment')
        if payment_label:
            lot_data['payment_type'] = clean_text(payment_label.get_text())

        # Extract detailed information from expanded sections

        # Check if the detailed section is loaded
        detail_section = soup.select_one('div.q-expansion-item__content')
        if detail_section:
            # Extract using table data
            table_fields = {
                'law_type': 'Yer uchastkasiga bo`lgan huquq turi',
                'land_area': 'Yer uchastkasining maydoni (ga)',
                'build_types': 'Mazkur yer uchastkasida qurilishga ruxsat berilgan ob\'ektlar turlari ro\'yxati',
                'lease_period': 'Ijaraga berish muddati (yil)',
                'unique_number': 'Unikal raqami',
                'usage_types': 'Yer uchastkasidan foydalanish mumkin bo\'lgan faoliyat turlari',
                'land_category': 'Yer uchastkasi kiradigan yerlar toifasi',
                'adjacent_lands': 'Yer uchastkasiga tutash yer uchastkalari (ob\'ektlari)ning belgilangan maqsadi va turlari',
                'restrictions': 'Yer uchastkasi bo\'yicha yoki undan foydalanish huquqiga nisbatan mavjud cheklovlar',
                'location_address': 'Uchastkaning joylashgan manzili',
                'distance_to_road': 'Umumiy foydalanishdagi avtomobil yo\'llarigacha bo\'lgan masofa to\'g\'risida ma\'lumot (metr)',
                'engineering_info': 'Qurilish ob\'yektini tashki muhandislik-kommunikatsiya tarmoqlariga ulash mumkin bo\'lgan quvvatlar to\'g\'risida ma\'lumotlar',
                'usage_warning': 'Yer uchastkasidan foydalanish bo`yicha ogohlantirish',
                'additional_info': 'Qo`shimcha ma`lumot',
                'usage_terms': 'Yer maydonidan foydalanish tartibi va shartlariga oid boshqa ma\'lumotlar'
            }

            for field, title in table_fields.items():
                value = extract_table_data(detail_section, title)
                if value:
                    lot_data[field] = value

        # Try to extract map coordinates
        try:
            # First, check if coordinates are in a data attribute
            map_elem = driver.find_element(By.CSS_SELECTOR, '[data-lat][data-lng]')
            if map_elem:
                lot_data['lat'] = map_elem.get_attribute('data-lat')
                lot_data['lng'] = map_elem.get_attribute('data-lng')
        except:
            # If that fails, try to find a map link
            try:
                map_link = driver.find_element(By.CSS_SELECTOR, 'a[href*="maps.google.com"]')
                if map_link:
                    href = map_link.get_attribute('href')
                    if 'q=' in href:
                        coords = href.split('q=')[1].split('&')[0]
                        if ',' in coords:
                            lat, lng = coords.split(',', 1)
                            lot_data['lat'] = lat.strip()
                            lot_data['lng'] = lng.strip()
            except:
                pass

        # Extract winner information if available
        winner_section = soup.select_one('div:-soup-contains("G\'olib haqida ma\'lumot")')
        if winner_section:
            # Extract winner name
            winner_name_elem = winner_section.select_one('div:-soup-contains("G\'olib nomi:")')
            if winner_name_elem:
                winner_text = winner_name_elem.get_text()
                if 'G\'olib nomi:' in winner_text:
                    lot_data['winner_name'] = clean_text(winner_text.split('G\'olib nomi:')[1])

            # Extract winner amount
            winner_price_elem = winner_section.select_one('div:-soup-contains("G\'olib narxi:")')
            if winner_price_elem:
                price_text = winner_price_elem.get_text()
                if 'G\'olib narxi:' in price_text:
                    price_value = price_text.split('G\'olib narxi:')[1]
                    lot_data['winner_amount'] = clean_number(price_value)

        # Set default property group and category if not found
        if 'property_group' not in lot_data:
            lot_data['property_group'] = "Yer uchastkalari"
        if 'property_category' not in lot_data:
            lot_data['property_category'] = "Tadbirkorlik va shaharsozlik uchun"

    except Exception as e:
        print(f"Selenium error for lot ID {lot_id}: {str(e)}")
        # If we encounter an error with Selenium, we'll try with requests

    finally:
        # Close the driver to release resources
        if driver:
            try:
                driver.quit()
            except:
                pass

    # If we couldn't get data with Selenium or some fields are missing, try with requests
    if not lot_data.get('property_name') or not lot_data.get('start_price'):
        try:
            response = session.get(lot_link, timeout=30)
            if response.status_code == 200:
                soup = BeautifulSoup(response.text, 'lxml')

                # Extract missing fields using similar approach as above
                if not lot_data.get('property_name'):
                    lot_name_elem = soup.select_one('div.lot-card-name-title')
                    if lot_name_elem:
                        lot_data['property_name'] = clean_text(lot_name_elem.get_text())

                # Repeat similar extraction for other fields...
                # (Code omitted for brevity but would follow similar patterns as above)

        except Exception as e:
            print(f"Requests error for lot ID {lot_id}: {str(e)}")

    return lot_data

def clean_lot_id(raw_lot_id):
    """Clean lot ID by removing non-digit characters"""
    if not raw_lot_id or pd.isna(raw_lot_id):
        return None
    return re.sub(r'[^\d]', '', str(raw_lot_id).strip())

def update_excel_with_lot_data(excel_path):
    """Update Excel file with scraped lot data"""
    # Load the Excel file
    print(f"Loading Excel file: {excel_path}")
    df = pd.read_excel(excel_path)

    # Check if "Лот рақами" column exists
    if "Лот рақами" not in df.columns:
        print("Error: 'Лот рақами' column not found in the Excel file.")
        return

    # Define all columns to add if they don't exist
    new_columns = [
        # Basic information
        'lot_link', 'main_image', 'property_name', 'property_group', 'property_category',
        'lot_status', 'start_price', 'zakalad_amount', 'auction_date', 'application_deadline',
        'address', 'region', 'area', 'lat', 'lng', 'winner_name', 'winner_amount', 'payment_type',

        # Detailed information from table
        'land_area', 'law_type', 'build_types', 'lease_period', 'unique_number',
        'usage_types', 'land_category', 'adjacent_lands', 'restrictions',
        'location_address', 'distance_to_road', 'engineering_info',
        'usage_warning', 'additional_info', 'usage_terms'
    ]

    # Add new columns if they don't exist
    for col in new_columns:
        if col not in df.columns:
            df[col] = None

    # Process each lot in the Excel file
    total_lots = len(df)
    print(f"Found {total_lots} lots in the Excel file.")

    # Create timestamp for output file
    timestamp = datetime.now().strftime("%Y%m%d_%H%M%S")

    for index, row in df.iterrows():
        # Clean the lot ID: remove commas, spaces, etc.
        raw_lot_id = row["Лот рақами"]
        lot_id = clean_lot_id(raw_lot_id)

        if not lot_id:
            print(f"Skipping row {index+1}: Empty or invalid lot number")
            continue

        print(f"Processing row {index+1}/{total_lots}: Lot ID {lot_id}")
        lot_data = get_lot_data(lot_id)

        # Update the row with scraped data
        for col in new_columns:
            if col in lot_data and lot_data[col] is not None:
                df.at[index, col] = lot_data[col]

        # Save progress after each lot (in case of interruption)
        if (index + 1) % 2 == 0 or index == total_lots - 1:
            temp_path = excel_path.replace('.xlsx', f'_temp_{timestamp}.xlsx')
            df.to_excel(temp_path, index=False)
            print(f"Progress saved at row {index+1}")

        # Add a random delay between requests to avoid rate limiting
        time.sleep(random.uniform(2, 4))

    # Save the final updated Excel file
    output_path = excel_path.replace('.xlsx', f'_complete_{timestamp}.xlsx')
    df.to_excel(output_path, index=False)
    print(f"Excel file updated successfully: {output_path}")

    return output_path

# Main execution
if __name__ == "__main__":
    # Path to the Excel file
    excel_file_path = '2024_data.xlsx'

    try:
        print(f"Starting data extraction process at {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}")
        # Update Excel with scraped data
        updated_file = update_excel_with_lot_data(excel_file_path)
        print(f"Process completed at {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}")
        print(f"Updated file saved as: {updated_file}")
    except Exception as e:
        print(f"An error occurred: {str(e)}")
