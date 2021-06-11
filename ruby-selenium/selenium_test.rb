require 'selenium-webdriver'

d = Selenium::WebDriver.for :chrome
# サイトの指定
d.get("https://katsulog.tech/")

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


urls = []
loop do
  d.find_elements(:class, 'post').each do |post|
    urls << post.find_element(:tag_name, 'h2').find_element(:tag_name, 'a').attribute("href")
  end

  if d.find_elements(:xpath, '//*[@class="next"]/nav/div/a[2]').size > 0
    d.find_element(:xpath, '//*[@class="next"]/nav/div/a[2]').click
  else
    break
  end

end

  urls.each do |url|
    d.get(url)
  end

# 2秒待機
sleep 2