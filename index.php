<?php $info=json_decode(file_get_contents('./info.json'), 1); ?>
<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="author" content="HCLonely" />
  <title>Live2d Model</title>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
  <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-rc.2/lazyload.js"></script>
  <style>[data-fancybox]{width:280px;display:inline-block;}[data-fancybox]>div{display:inline-block;width:100%;text-align:center;margin:10px 0 20px;}</style>
</head>
<body>
  <h1 align="center">适用于<a href="https://github.com/HCLonely/live2d.user.js" style="text-decoration: none;">live2d.user.js</a>脚本的模型</h1>
  <h3 align="center">可用模型更新到<?php echo $info["model"]; ?></h3>
  <h2 align="left">API请求次数: <?php echo intval(file_get_contents('./visitor.txt')) ?></h2>
  <h2 align="left">模型请求统计</h2>
  <?php
  for($i=1;$i<=$info["package"];$i++){
    echo '<img alt="l2dmodel_' . $i . '" src="https://img.shields.io/jsdelivr/npm/hm/l2dmodel_' . $i . '" />';
  }
  ?>
  <h2 align="left">模型来源:<a href="https://github.com/xiazeyu/live2d-widget-models">live2d-widget-models</a>, <a href="https://mx.paul.ren/page/1/" rel="nofollow">梦象</a>, <a href="https://github.com/Eikanya/Live2d-model">Live2d-model</a></h2>
  <h2 align="left" id="preview">模型预览</h2>
  <?php
  for ($i=1;$i<=$info["model"];$i++) {
    echo '<a data-fancybox="gallery" href="https://cdn.jsdelivr.net/gh/HCLonely/live2d_api@master/preview/' . $i . '.webp" data-caption="模型' . $i . '-0"><img class="lazyload" alt="模型' . $i . '-0" data-src="https://cdn.jsdelivr.net/gh/HCLonely/live2d_api@master/preview/' . $i . '.webp" /><div>模型' . $i . '-0</div></a>';
  }
  ?>
  <script>lazyload();$().fancybox({selector:'[data-fancybox]',loop:true,transitionEffect:'slide',protect:true,buttons:['slideShow','fullScreen','thumbs','close']});$(document).ready(function(){var WebP=new Image();WebP.onload=WebP.onerror=function(){if(WebP.height!=2){var sc=document.createElement('script');sc.type='text/javascript';sc.async=true;var s=document.getElementsByTagName('script')[0];sc.src='https://cdn.jsdelivr.net/gh/HCLonely/hclonely.github.io@1.2.0/js/webpjs.min.js';s.parentNode.insertBefore(sc,s);}};WebP.src='data:image/webp;base64,UklGRjoAAABXRUJQVlA4IC4AAACyAgCdASoCAAIALmk0mk0iIiIiIgBoSygABc6WWgAA/veff/0PP8bA//LwYAAA';});</script>
</body>
</html>