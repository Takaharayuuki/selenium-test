# セレニウムの読込
require 'selenium-webdriver'
# CSVライブラリの使用
require 'csv'

# ログを取る
log_file = File.join('./', "function.log")
@log = Logger.new(log_file)

def log(msg)
  @log.debug(msg)
end

# csvファイルにbomを追加
bom = %w(EF BB BF).map { |e| e.hex.chr }.join
csv_file = CSV.generate(bom) do |csv|
  csv << ["Selenium"]
end

File.open("esult.csv","w") do |file|
  file.write(csv_file)
end

d = Selenium::WebDriver.for :chrome
# サイトの指定
d.get("https://katsulog.tech/")
# 待機の指定
wait = Selenium::WebDriver::Wait.new(:timeout => 10)



# id="post-224"の中のpタグのテキストを取得して表示
# puts d.find_element(:id, 'post-224').find_element(:tag_name, 'p').text

# class="post"の要素の中のh2タグのテキストを取得して表示
# d.find_elements(:class, 'post').each do |post|
#   puts post.find_element(:tag_name, 'h2').text
# end

# class="post"の要素の中のh2タグのテキストを配列に代入し、eachでタイトルを表示する
# titles = []
# d.find_elements(:class, 'post').each do |post|
#   require 'debug'
#   titles << post.find_element(:tag_name,'h2').text
# end

# titles.each do |title|
#   puts title
# end

d.find_element(:name, 's').send_key('Selenium')
d.find_element(:class, 'searchsubmit').click


urls = []
loop do
  # class="post"が現れるまで待つ wait.untilの中に書いてあることがtrueになるまで待つ処理
  wait.until { d.find_elements(:class, 'post').size > 0 }
  d.find_elements(:class, 'post').each do |post|
    urls << post.find_element(:tag_name, 'h2').find_element(:tag_name, 'a').attribute("href")
  end

  if d.find_elements(:xpath, '//*[@class="next page-numbers"]').size > 0
    wait.until { d.find_elements(:xpath, '//*[@class="next page-numbers"]').size > 0 }
    d.find_element(:xpath, '//*[@class="next page-numbers"]').click
  else
    break
  end
end

i = 1
  urls.each do |url|
    d.get(url)
    title = d.find_element(:id, 'main').find_element(:tag_name, 'h2').text
    page_url = d.current_url
    CSV.open("esult.csv","a") do |file|
      file << ["最高"]
    end
    i += 1
  end

# 2秒待機
sleep 2