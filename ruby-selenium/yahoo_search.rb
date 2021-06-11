# セレニウムの読込
require 'selenium-webdriver'
# CSVライブラリの使用
require 'csv'

# ログを取る
log_file = File.join('./', "yahoo_debug.log")
@log = Logger.new(log_file)
def log(msg)
  @log.debug(msg)
end

# クロームでセレニウムを起動
d = Selenium::WebDriver.for :chrome
# サイトの指定
d.get("https://www.yahoo.co.jp/")
# 待機の指定
wait = Selenium::WebDriver::Wait.new(:timeout => 10)

# エレメントの取得
begin
  search_box = d.find_element(:name, 'p')
  search_submit = d.find_element(:xpath, '//*[@id="ContentWrapper"]/header/section[1]/div/form/fieldset/span/button')
rescue Selenium::WebDriver::Error::NoSuchElementError
  p 'no such element error!!'
  return
end

search_box.send_keys 'Ruby'
search_submit.click

sleep 4

driver.quit