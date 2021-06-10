require 'selenium-webdriver'

driver = Selenium::WebDriver.for :chrome
driver.manage.timeouts.implicit_wait = 60

driver.get('https://www.yahoo.co.jp/')

sleep 2