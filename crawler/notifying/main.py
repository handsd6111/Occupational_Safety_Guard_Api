from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.options import Options
from selenium import webdriver
from selenium.webdriver.support.ui import Select
import json
import time

chrome_options = Options()
chrome_options.add_argument('--no-sandbox')
chrome_options.add_argument('--disable-dev-shm-usage')
chrome_options.add_argument('--headless')  # 啟動Headless 無頭
chrome_options.add_argument('--disable-gpu')  # 關閉GPU 避免某些系統或是網頁出錯
# 加上表頭，模擬真人
chrome_options.add_argument(
    "user-agent=Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3")

# s = Service(r"./tools/chromedriver.exe")
s = Service(r"/usr/local/bin/chromedriver")
url = 'https://insp.osha.gov.tw/labcbs/dis0001.aspx'

driver = webdriver.Chrome(service=s,options=chrome_options)  # 套用設定
driver.set_window_size(1920, 1080)  # 無頭設定視窗大小才不會有錯誤
driver.maximize_window()  # 同上


class Common:
    # 建構式
    def __init__(self, code, name):
        self.code = code  # 行業代碼
        self.name = name  # 行業名稱
        
print('開始抓取「職災網路通報」資料：')
start = time.time()

driver.get(url)  # 訪問URL
# print(driver.page_source)
driver.find_element(By.ID, 'btndisnotify').click()

accidentTypeOptions = driver.find_element(By.ID, 'a_DT_code').find_elements(By.TAG_NAME, 'option')
degreeOfInjuryOptions = driver.find_element(By.ID, 'dgListH_DD_code_0').find_elements(By.TAG_NAME, 'option')
insuranceOptions = driver.find_element(By.ID, 'dgListH_is_insu_0').find_elements(By.TAG_NAME, 'option')
notityingAgencyOption = driver.find_element(By.ID, 'u_deptno').find_elements(By.TAG_NAME, 'option')
victimIdentityOptions = driver.find_element(By.ID, 'dgListH_DK_code_0').find_elements(By.TAG_NAME, 'option')
countyOptions = driver.find_element(By.ID, 'a_city_code').find_elements(By.TAG_NAME, 'option')
result = {}

# 災害類型
for index, option in enumerate(accidentTypeOptions):
    if(index == 0): continue
    accidentType = Common(
        option.get_attribute('value'),
        option.text
    )
    if ('accident_types' not in result):
        result['accident_types'] = []
    result['accident_types'].append(accidentType.__dict__)
    
# 罹災程度
for index, option in enumerate(degreeOfInjuryOptions):
    if(index == 0): continue
    degreeOfInjury = Common(
        option.get_attribute('value'),
        option.text
    )
    degreeOfInjuryDict = degreeOfInjury.__dict__
    if ('degree_of_injuries' not in result):
        result['degree_of_injuries'] = []
    degreeOfInjuryDict['need_hospital'] = []
    if(degreeOfInjury.code == '0002'):
        needHospital = Common('Y', '(Y)需住院治療')
        noneHospital  = Common('N', '(N)不需住院治療')
        degreeOfInjuryDict['need_hospital'] = [needHospital.__dict__, noneHospital.__dict__]
    result['degree_of_injuries'].append(degreeOfInjuryDict)

# 投保情形
for index, option in enumerate(insuranceOptions):
    if(index == 0): continue
    insurance = Common(
        option.get_attribute('value'),
        option.text
    )
    if ('insurances' not in result):
        result['insurances'] = []
    result['insurances'].append(insurance.__dict__)

# 罹災者身份
for index, option in enumerate(victimIdentityOptions):
    if(index == 0): continue
    victimIdentity = Common(
        option.get_attribute('value'),
        option.text
    )
    if ('victim_identites' not in result):
        result['victim_identites'] = []
    result['victim_identites'].append(victimIdentity.__dict__)
    
# 縣市
for index, option in enumerate(countyOptions):
    if(index == 0): continue
    county = Common(
        option.get_attribute('value'),
        option.text
    )
    if ('counties' not in result):
        result['counties'] = []
    result['counties'].append(county.__dict__)
    
# 縣市
for index, county in enumerate(result['counties']):
    driver.back()
    driver.find_element(By.ID, 'btndisnotify').click()
    select = Select(driver.find_element(By.ID, 'a_city_code'))
    select.select_by_value(county['code'])
    time.sleep(0.2)
    townOptions = driver.find_element(By.ID, 'a_zone_code').find_elements(By.TAG_NAME, 'option')
    for tIndex, option in enumerate(townOptions):
        if(tIndex == 0): continue
        town = Common(
            option.get_attribute('value'),
            option.text
        )
        if ('towns' not in county):
            county['towns'] = []
        result['counties'][index]['towns'].append(town.__dict__)
        
    notifyingAgnecyOptions = driver.find_element(By.ID, 'u_deptno').find_elements(By.TAG_NAME, 'option')
    for naIndex, option in enumerate(notifyingAgnecyOptions):
        if(naIndex == 0): continue
        notifyingAgency = Common(
            option.get_attribute('value'),
            option.text
        )
        if ('notifying_agency' not in county):
            county['notifying_agency'] = []
        result['counties'][index]['notifying_agency'].append(notifyingAgency.__dict__)

with open('../../storage/app/notifying.json', 'w') as file:
    json.dump(result, file)
    
end = time.time()
print('執行成功，總共耗時 %f 秒' % (end - start))
