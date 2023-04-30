import requests as rq
import xml.etree.cElementTree as et
import sys
sys.path.append('../')
from sql.common import execSql, checkRowIsExists, insertOneRow, updateOneRow

apiLink = "https://api.nlsc.gov.tw/other/ListCounty"
output = rq.get(apiLink)
# print(output.text)

tree = et.fromstring(output.text)

for county in tree.findall('countyItem'):
    countyCode = county[0].text
    countyName = county[1].text
    columns = ['code', 'name']  # notifying_agencies的欄位
    datas = [countyCode, countyName]
    
    # SQL
    if(checkRowIsExists('counties', ['code'], [countyCode])): # 確認是否有此筆資料，有此筆
        execSql(updateOneRow('counties',columns, datas, ['code'], [countyCode])) # 更新資料
    else: # 沒有此筆資料
        execSql(insertOneRow('counties', columns, datas)) # 則寫入
        
    # 做鄉鎮市區
    townApiLink = "https://api.nlsc.gov.tw/other/ListTown1/{countyCode}".format(countyCode=countyCode)
    townOutput = rq.get(townApiLink).text
    townTree = et.fromstring(townOutput)
    
    for town in townTree.findall('townItem'):
        townCode = town[1].text 
        townName = town[2].text 
        columns = ['code', 'name', 'county_code']
        datas = [townCode, townName, countyCode]
        
        # SQL
        if(checkRowIsExists('towns', ['code'], [townCode])): # 確認是否有此筆資料，有此筆
            execSql(updateOneRow('towns',columns, datas, ['code'], [townCode])) # 更新資料
        else: # 沒有此筆資料
            execSql(insertOneRow('towns', columns, datas)) # 則寫入
            
        
        
