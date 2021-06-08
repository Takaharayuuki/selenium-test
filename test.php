<?php
require './vendor/autoload.php';

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

// 今回の買い物サイト用に準備する変数。
// 検索したいワードを$wordに入れる。この例だとamazonと検索した場合
$word = 'amazon';
$title = " ********** "; // ここは秘密。htmlのtitleに表示される文言を記述

// chrome利用用意
$options = new ChromeOptions();
// headlessモードで対応
$options->addArguments(['--headless']);
// ブラウザのサイズを指定
$options->addArguments(["window-size=1024,2048"]);

$host = 'http://localhost:4444/wd/hub';
$capabilities = Facebook\WebDriver\Remote\DesiredCapabilities::chrome();
$capabilities->setCapability(ChromeOptions::CAPABILITY, $options);
$driver = Facebook\WebDriver\Remote\RemoteWebDriver::create($host, $capabilities);
//スクレイピングしたいアドレスを入力
$driver->get('https://www.amazon.co.jp/b/?node=466280&ref_=Oct_s9_apbd_odnav_hd_bw_b1x4K_0&pf_rd_r=H3DCEMC15ZH8C7SDMFFV&pf_rd_p=502a2394-a2dd-535a-bb19-7002caa2f8ea&pf_rd_s=merchandised-search-10&pf_rd_t=BROWSE&pf_rd_i=465392');
$browserLogs = $driver->manage()->getLog('browser');
// 検索したい語をsendKeys()に入れて、submitする。ここの'q'はサイトによって異なる。
$element = $driver->findElement(WebDriverBy::name('q'));
$element->sendKeys($word);
$element->submit();

// このサイトでは、商品画像を全部表示するため、画面を少し右に移動
$driver->executeScript("window.scrollTo(300, 0);");
$driver->wait(15)->until(
    WebDriverExpectedCondition::titleIs($title)
);

// もし、$title（htmlの<title>が想定どおりじゃない）がなければ、なにかした失敗していると判断
if ($driver->getTitle() !== "$title") {
    throw new Exception('fail');
}

// 以下取得したい要素を指定してあげる。
// 今回は、検索結果のURL、写真、名前を取得したいので以下の用になっている。
// cssSelectorはサイトに寄って異なる。
$itemUrls = $driver->findElements(WebDriverBy::cssSelector('div.c2iYAv > div.cRjKsc > a'));
$photos = $driver->findElements(WebDriverBy::cssSelector('.c5TXIP .c2iYAv .cRjKsc .c1ZEkM'));
$productNames = $driver->findElements(WebDriverBy::cssSelector('.c5TXIP .c3KeDq .c16H9d'));

$items = [];
// 商品あるかチェック
if (count($photos) < 0) {
    throw new Exception('no item.');
}

//。今回は上から１０件だけ取得して、情報を$item配列に格納する。
foreach ($itemUrls as $k => $v) {
    if ($k === 10) {
        break;
    }
    $items[$k]['$itemUrl'] = $v->getAttribute('href');
}
foreach ($photos as $k => $v) {
    if ($k === 10) {
        break;
    }
    $items[$k]['photoUrl'] = $v->getAttribute('src');
}
foreach ($productNames as $k => $v) {
    if ($k === 10) {
        break;
    }
    $items[$k]['titleName'] = $v->getText();
}

print_r($items);
echo "\n";

// ↓コメントアウト外せば、どこをスクレイピングしているかとスクリーンショットで確認できる↓
$file = "sumple_chrome.png";
$driver->takeScreenshot($file);
$driver->close();