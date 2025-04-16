# import re
# import requests
# from selenium import webdriver
# from selenium.webdriver.common.by import By
# from selenium.webdriver.chrome.service import Service
# from selenium.webdriver.support.ui import WebDriverWait
# from selenium.webdriver.support import expected_conditions as EC
# from webdriver_manager.chrome import ChromeDriverManager
# from bs4 import BeautifulSoup
# import time
# import json
import subprocess
import sys

# Auto-install packages if not found
required_packages = ['selenium', 'webdriver-manager', 'beautifulsoup4', 'requests']
for pkg in required_packages:
    try:
        __import__(pkg.replace('-', '_'))
    except ImportError:
        subprocess.check_call([sys.executable, "-m", "pip", "install", pkg])

# Now continue with the actual imports
import re
import requests
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from webdriver_manager.chrome import ChromeDriverManager
from bs4 import BeautifulSoup
import time
import json
# Set up the Selenium WebDriver
options = webdriver.ChromeOptions()
options.add_argument('--headless')  # Run headless Chrome
options.add_argument('--no-sandbox')
options.add_argument('--disable-dev-shm-usage')

# Initialize the WebDriver
driver = webdriver.Chrome(service=Service(ChromeDriverManager().install()), options=options)

def get_lots_from_page(url):
    driver.get(url)
    # Wait for the lots to be present
    WebDriverWait(driver, 15).until(EC.presence_of_all_elements_located((By.CSS_SELECTOR, 'div.lot-view')))
    web_content = driver.page_source
    soup = BeautifulSoup(web_content, 'html.parser')
    lots = soup.select('div.lot-view')
    return [parse_lot(lot) for lot in lots]

def parse_lot(lot):
    lot_data = {}

    # Extract image URL
    image_div = lot.select_one('div.q-img__image')
    if image_div:
        style = image_div.get('style', '')
        if 'background-image:' in style:
            lot_data['main_image'] = style.split('background-image: url("')[1].split('");')[0]

    # Extract lot number
    lot_number = lot.select_one('span.ea-lot-number')
    if lot_number:
        lot_data['lot_number'] = lot_number.text.strip().replace("№ ", "")

    # Extract lot name
    lot_name = lot.select_one('p.lot-value.lot-name label')
    if lot_name:
        lot_data['property_name'] = lot_name.text.strip()

    # Extract and parse starting price
    starting_price_label = lot.find('p', class_='lot-title', string='Boshlang‘ich narxi:')
    if starting_price_label:
        starting_price_value = starting_price_label.find_next_sibling('p', class_='lot-value')
        if starting_price_value:
            raw_value = starting_price_value.text.strip()
            # Remove all non-digit and non-decimal characters
            cleaned_value = re.sub(r'[^0-9.]', '', raw_value)
            if cleaned_value:
                try:
                    lot_data['start_price'] = float(cleaned_value)
                except ValueError:
                    lot_data['start_price'] = None

    # Extract and parse deposit amount
    deposit_amount_label = lot.find('p', class_='lot-title', string='Zakalat puli miqdori')
    if deposit_amount_label:
        deposit_amount_value = deposit_amount_label.find_next_sibling('p', class_='lot-value')
        if deposit_amount_value:
            raw_value = deposit_amount_value.text.strip()
            cleaned_value = re.sub(r'[^0-9.]', '', raw_value)
            if cleaned_value:
                try:
                    lot_data['zakalad_amount'] = float(cleaned_value)
                except ValueError:
                    lot_data['zakalad_amount'] = None

    # Extract auction time
    auction_time_label = lot.find('p', class_='lot-title', string='Savdo vaqti:')
    if auction_time_label:
        auction_time_value = auction_time_label.find_next_sibling('p', class_='lot-value')
        if auction_time_value:
            lot_data['auction_date'] = auction_time_value.text.strip()

    # Extract application deadline
    application_deadline_label = lot.find('p', class_='lot-title', string='Arizalarni qabul qilishning oxirgi muddati:')
    if application_deadline_label:
        application_deadline_value = application_deadline_label.find_next_sibling('p', class_='lot-value')
        if application_deadline_value:
            lot_data['application_deadline'] = application_deadline_value.text.strip()

    # Extract address
    address_label = lot.find('p', class_='lot-title', string='Manzil:')
    if address_label:
        address_value = address_label.find_next_sibling('p', class_='lot-value')
        if address_value:
            address_parts = address_value.text.strip().split(', ')
            if len(address_parts) == 3:
                lot_data['region'] = address_parts[0]
                lot_data['area'] = address_parts[1]
                lot_data['address'] = address_parts[2]
            elif len(address_parts) == 2:
                lot_data['region'] = address_parts[0]
                lot_data['address'] = address_parts[1]

    # Navigate to the lot detail page and extract additional information
    if 'lot_number' in lot_data:
        lot_link = f"https://e-auksion.uz/lot-view?lot_id={lot_data['lot_number']}"
        lot_data['lot_link'] = lot_link
        driver.get(lot_link)
        # Wait for the map link
        WebDriverWait(driver, 15).until(EC.presence_of_element_located((By.CSS_SELECTOR, "a[target='_blank'][href*='maps.google.com/?q=']")))
        detail_soup = BeautifulSoup(driver.page_source, 'html.parser')

        # Extract additional details
        lot_data['land_area'] = detail_soup.select_one("td:-soup-contains('Yer uchastkasining maydoni (ga)') + td").text.strip() \
            if detail_soup.select_one("td:-soup-contains('Yer uchastkasining maydoni (ga)') + td") else None

        lot_data['build_types'] = detail_soup.select_one("td:-soup-contains('Mazkur yer uchastkasida qurilishga ruxsat berilgan ob’ektlar turlari ro‘yxati') + td").text.strip() \
            if detail_soup.select_one("td:-soup-contains('Mazkur yer uchastkasida qurilishga ruxsat berilgan ob’ektlar turlari ro‘yxati') + td") else None

        lot_data['law_type'] = detail_soup.select_one("td:-soup-contains('Yer uchastkasiga bo`lgan huquq turi') + td").text.strip() \
            if detail_soup.select_one("td:-soup-contains('Yer uchastkasiga bo`lgan huquq turi') + td") else None

        # Extract map coordinates
        map_link = detail_soup.select_one("a[target='_blank'][href*='maps.google.com/?q=']")
        if map_link:
            coords_param = map_link.get('href').split('q=')[1] if 'q=' in map_link.get('href') else ''
            coords = coords_param.split(',')
            if len(coords) == 2:
                lot_data['lat'] = coords[0]
                lot_data['lng'] = coords[1]

        # Additional fixed fields
        lot_data.update({
            "property_group": "Yer uchastkalari",
            "property_category": "Tadbirkorlik va shaharsozlik uchun",
            "lot_status": "Savdoda ishtirok etish uchun elektron arizalarni qabul qilish",
            "winner": None,
            "winner_amount": None,
            "winner_name": None,
            "payment_type": "Muddatli bo‘lib to‘lash",
            "trade_type": 1,
            "building_area": None,
            "contract_number": None,
            "contract_date": None
        })

        # Return to the main page
        driver.back()
        time.sleep(5)  # Adjust as needed

    return lot_data

# Function to handle pagination
def get_all_lots(base_url, max_pages=20):
    all_lots = []
    for page in range(1, max_pages + 1):
        url = f"{base_url}&page={page}"
        lots = get_lots_from_page(url)
        if not lots:
            break
        all_lots.extend(lots)
    return all_lots

# Base URL for the auction lots
base_url = "https://e-auksion.uz/lots?group=6&index=1&address=&lt=0&at=0&order=0&q=&hashtag=&region=1"

# Get all lots
all_lots = get_all_lots(base_url)

# Structure output in the required JSON format
output = {
    "lots": all_lots
}

# Output the JSON to a file
with open('lots.json', 'w', encoding='utf-8') as f:
    json.dump(output, f, ensure_ascii=False, indent=4)

# Close the WebDriver
driver.quit()
