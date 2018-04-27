<?php
/**
 * wechat api test
 */


class Wechatapi
{

    public $appid = "";
    public $appsecret = "";

    /**
     * 获取Access Token
     *
     * @return string
     */
    public function getAccessToken()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appid}&secret={$this->appsecret}";

        $output = $this->httpsRequest($url);
        $jsoninfo = json_decode($output, true);
        $access_token = $jsoninfo["access_token"];

        return $access_token;
    }

    /**
     * 创建自定义菜单
     */
    public function createMenu()
    {

        $menuArr = array(
            "button" => array(
                array("type"=>"view", "name"=>urlencode("首页"), "url"=>"http://wx.maczen.cn/weui/index.php"),
                array(
                    "name" => urlencode("发图测试"),
                    "sub_button"=>array(
                        array("type"=>"pic_sysphoto", "name"=>urlencode("拍照发图"), "key"=>"rselfmenu_1_0", "sub_button"=>array()),
                        array("type"=>"pic_photo_or_album", "name"=>urlencode("相册发图"), "key"=>"rselfmenu_1_1", "sub_button"=>array()),
                        array("type"=>"location_select", "name"=>urlencode("发送位置"), "key"=>"rselfmenu_1_2"),
                        array("type"=>"scancode_waitmsg", "name"=>urlencode("扫一扫"), "key"=>"rselfmenu_1_3"),
                    ),
                ),
                array(
                    "name" => urlencode("公司简介"),
                    "sub_button"=>array(
                        array("type"=>"media_id", "name"=>urlencode("最新资讯"), "media_id"=>"JcX0UIGCrSnFHpsbzk4OeVO22e4NtxVJZXoaoFKd-_0"),
                        array("type"=>"media_id", "name"=>urlencode("公司简介"), "media_id"=>"JcX0UIGCrSnFHpsbzk4OeQ3EVDDAFe_mXHuagesWAoo"),
                        array("type"=>"view_limited", "name"=>urlencode("联系我们"), "media_id"=>"JcX0UIGCrSnFHpsbzk4OeVO22e4NtxVJZXoaoFKd-_0"),
                    ),
                ),
            ),
        );

        $postdata = urldecode(json_encode($menuArr));

        $access_token = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
        $result = $this->httpsRequest($url, $postdata);

        var_dump($result);
    }

    /**
     * 新增永久图片素材
     */
    public function resourceAddImg()
    {
        //JcX0UIGCrSnFHpsbzk4OeVQ_YSHdqtAGxcSoTLnUrXg

        $imgsrc = "/images/img6.jpg";
        $real_path="{$_SERVER['DOCUMENT_ROOT']}{$imgsrc}";

        $file_info=array(
            'filename'=>$imgsrc,
            'content-type'=>'image/jpeg',
            'filelength'=>filesize($real_path)
        );


        $access_token = $this->getAccessToken();

        $url="https://api.weixin.qq.com/cgi-bin/material/add_material?access_token={$access_token}&type=image";
        $curl = curl_init();
        $timeout = 5;
        $data= array("media"=>"@{$real_path}",'form-data'=>$file_info);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($curl);
        curl_close($curl);

        var_dump($result);

    }

    /**
     * 新增永久图文素材
     */
    public function resourceAddNews()
    {

        //JcX0UIGCrSnFHpsbzk4OeQGLZQSOpaUD3nIaXdwNQ_0
        //JcX0UIGCrSnFHpsbzk4Oebz2Mz51QOGqueagh1vyQ9Y

        //JcX0UIGCrSnFHpsbzk4OeRd6NU6279jHkB-mXnY2CV4 多图文

        //JcX0UIGCrSnFHpsbzk4OeVO22e4NtxVJZXoaoFKd-_0


        $articles =array(
            array(
                'title' => urlencode('iphone7新功能专利，揭示了什么是真正的黑科技'),
                'thumb_media_id' => "JcX0UIGCrSnFHpsbzk4OebM8qBMJ97fYGDjmxobhuFQ",
                'author' => urlencode('Iphone'),
                'digest' => urlencode('双摄像头，home键3D-Touch的原理是什么？怎样才是预测苹果推出新技术的正确姿势？'),
                'show_cover_pic' => 1,
                'content' => urlencode('<p>事实上，在苹果推出双摄像头手机之前，已经有多家国内外手机公司推出了双摄像头手机（比如LG的Optimus 3D、HTC的One M8、以及铺天盖地的华为P9广告），或者已经申请了相关的专利（比如国外的LG、三星，国内的OPPO、酷派、中兴）。</p><p>而苹果公司2015年才开始有相关专利申请，而最重要的就是下面这一件了。</p>'),
                'content_source_url' => 'http://peterlin.baijia.baidu.com/article/621263'
            ),
            array(
                'title' => urlencode('在大数据时代，每家公司都要有大数据部门吗？'),
                'thumb_media_id' => "JcX0UIGCrSnFHpsbzk4OeU2LOA7AudBfqtU-o0Ba4T8",
                'author' => urlencode('牛透社'),
                'digest' => urlencode('事实上每一种重大技术的出现，都会对产业产生大的变化...'),
                'show_cover_pic' => 1,
                'content' => urlencode('<p>如果这个问题换做是：在电气时代，每家公司都要有个发电厂吗？是不是会更好回答一些？</p><p>事实上每一种重大技术的出现，都会对产业产生大的变化。在蒸汽时代，采矿机采用蒸汽机后，会带来生产效率的极大提升，而轮船加上蒸汽机，再也不需要靠风才能航海了。在电气时代，电灯代替了蜡烛，电报代替了快马送信，而报纸也被广播和电视所侵蚀。</p>'),
                'content_source_url' => 'http://cuiqiang2008.baijia.baidu.com/article/621105'
            ),
            array(
                'title' => urlencode('阿里、京东，电商巨头要用VR颠覆零售，能行吗？'),
                'thumb_media_id' => "JcX0UIGCrSnFHpsbzk4OedfNGwMueCfxmKYcXktTHA4",
                'author' => urlencode('杨梦莹'),
                'digest' => urlencode('近日，京东首次对外公布了其VR/AR战略，宣布成立电商领域首个“VR/AR产业推进联盟”，同时今年9月，阿里巴巴Buy+即将测试上线，业内兴起了VR电商热潮。不止国内，国外的电商平台对于VR/AR也是蠢蠢欲动，渐渐露出了发展动向，VR电商战役刚刚开始，接下来一起看看他们各自的动态吧。'),
                'show_cover_pic' => 1,
                'content' => urlencode('2016年3月，阿里巴巴宣布成立VR实验室（GM Lab），启动Buy+计划。在今年7月22日的“淘宝造物节”上，VR虚拟购物平台Buy+首度对外开放。不仅是虚拟购买环节，在支付方面阿里巴巴也有所涉及。由蚂蚁金服推出的VR Pay虚拟购物支付技术预计本月底落地，可以在应用内完成3D场景下的支付，真正形成闭环。用户在接入了VR Pay的商家店铺内下单后，VR界面内会跳出一个3D形态的支付宝收银台，用户根据所佩戴的VR硬件设备的操作特点，通过凝视、点头、手势等控制方法登陆支付宝账户，并输入密码完成交易。'),
                'content_source_url' => 'http://iyiou.baijia.baidu.com/article/620851'
            ),
        );

        $data = array(
            'articles' => $articles
        );

        $postdata = urldecode(json_encode($data));


        $access_token = $this->getAccessToken();

        $url="https://api.weixin.qq.com/cgi-bin/material/add_news?access_token={$access_token}";
        $result = $this->httpsRequest($url, $postdata);


        var_dump($result);

    }

    /**
     * 修改永久图文素材
     */
    public function resourceEditNews()
    {

        //JcX0UIGCrSnFHpsbzk4OeQ3EVDDAFe_mXHuagesWAoo

        $media_id = "JcX0UIGCrSnFHpsbzk4Oebz2Mz51QOGqueagh1vyQ9Y";
        $thumb_media_id = "JcX0UIGCrSnFHpsbzk4OecrHmfESxoknNXlD-jILMBU";


        $articles =array(
            array(
                'title' => urlencode('关于Maczen'),
                'thumb_media_id' => $thumb_media_id,
                'author' => urlencode('maczen'),
                'digest' => "",
                'show_cover_pic' => 1,
                'content' => urlencode('<p>About Mac And Zen</p>'),
                'content_source_url' => 'http://www.maczen.cn'
            ),
        );

        $data = array(
            'media_id'=>$media_id,
            'index'=>0,
            'articles' => $articles
        );

        $postdata = urldecode(json_encode($data));


        $access_token = $this->getAccessToken();
        $url="https://api.weixin.qq.com/cgi-bin/material/add_news?access_token={$access_token}";
        $result = $this->httpsRequest($url, $postdata);

        var_dump($result);
    }


    /**
     * 删除永久素材
     */
    public function resourceDel()
    {

        $media_id = "JcX0UIGCrSnFHpsbzk4OeQGLZQSOpaUD3nIaXdwNQ_0";
        $postdata = json_encode(array("media_id"=>$media_id));

        $access_token = $this->getAccessToken();
        $url="https://api.weixin.qq.com/cgi-bin/material/del_material?access_token={$access_token}";
        $result = $this->httpsRequest($url, $postdata);

        var_dump($result);
    }



    /**
     * 获取永久素材列表
     */
    public function resourceList()
    {

        $data = array(
            'type' => "image",
            'offset' => 0,
            'count' => 20,
        );

        $access_token = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token={$access_token}";

        $result = $this->httpsRequest($url, json_encode($data));

        print_r(json_decode($result, true));
    }


    /**
     * 获取永久素材
     */
    public function resourceGet()
    {

        $media_id = "JcX0UIGCrSnFHpsbzk4OeduhwuaOhGiDxJPJawob2qY";
        $postdata = json_encode(array("media_id"=>$media_id));

        $access_token = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/material/get_material?access_token={$access_token}";

        $result = $this->httpsRequest($url, $postdata);

        print_r(json_decode($result, true));
    }

    /**
     * 获取材临时素
     */
    public function mediaGet()
    {

        $media_id = "am9revc8M5M7OeQgxkmILF1PLX0giIAC9WLKeBcyLTs867JIEBuVnsLuCE7-4z5B";

        $access_token = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/media/get?access_token={$access_token}&media_id={$media_id}";

        $result = $this->httpsRequest($url);

        //header("Content-type:image/jpeg");
        //echo $result;

        file_put_contents("1.jpg", $result);

    }




    /**
     * CURL请求
     *
     * @param $url
     * @param null $data
     * @return mixed
     */
    public function httpsRequest($url,$data = null){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
}


header("Content-type:text/html;charset=utf-8");

error_reporting(E_ALL);
@ini_set("display_errors", 1);

$weburl = "http://wx.maczen.cn/api.php";

$wechatObj = new Wechatapi();

$action = isset($_GET["action"]) ? $_GET["action"]:"";
if(!empty($action) && method_exists($wechatObj, $action)){
    $wechatObj->$action();
    echo "<hr>";
}

$list = array(
    array("name"=>"创建自定义菜单", "action"=>"createMenu"),
    array("name"=>"获取永久素材列表", "action"=>"resourceList"),
    array("name"=>"获取永久素材", "action"=>"resourceGet"),
    array("name"=>"新增永久图文素材", "action"=>"resourceAddNews"),
    array("name"=>"删除永久图文素材", "action"=>"resourceDel"),
    array("name"=>"修改永久图文素材", "action"=>"resourceEditNews"),
    array("name"=>"新增永久图片素材", "action"=>"resourceAddImg"),
    array("name"=>"获取临时素材", "action"=>"mediaGet"),
);


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>微信高级接口测试</title>
</head>
<body>
<ul>
    <li><a href="<?php echo $weburl; ?>">微信高级接口测试</a></li>
    <?php foreach($list as $item){ ?>
        <li><a href="<?php echo $weburl."?action=".$item["action"]; ?>"><?php echo $item["name"]; ?></a></li>
    <?php } ?>
</ul>
</body>
</html>
