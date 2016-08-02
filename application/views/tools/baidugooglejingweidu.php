<title>谷歌与百度的坐标转换</title>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.2"></script>
<div style="width:520px;height:340px;border:1px solid gray" id="container"></div>
<div>
    谷歌<br />
    <input style="width:150px" value="120.39906" type="text" id="ggX" />
    <input style="width:150px" value="36.07183" type="text" id="ggY" />
    <input value="google->baidu" type="button" onclick="ggxy()" />
    <br />GPS
    <br />
    <input style="width:150px" value="120.39906" type="text" id="gpsX" />
    <input style="width:150px" value="36.07183" type="text" id="gpsY" />
    <input value="GPS->baidu" type="button" onclick="gpsxy()" />
    <br />百度<br />
    <span id="baiduXY"> </span>
    </div>
<script type="text/javascript">

(function(){        //闭包
function load_script(xyUrl, callback){
    var head = document.getElementsByTagName('head')[0];
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = xyUrl;
    //借鉴了jQuery的script跨域方法
    script.onload = script.onreadystatechange = function(){
        if((!this.readyState || this.readyState === "loaded" || this.readyState === "complete")){
            callback && callback();
            // Handle memory leak in IE
            script.onload = script.onreadystatechange = null;
            if ( head && script.parentNode ) {
                head.removeChild( script );
            }
        }
    };
    // Use insertBefore instead of appendChild  to circumvent an IE6 bug.
    head.insertBefore( script, head.firstChild );
}
function translate(point,type,callback){
    var callbackName = 'cbk_' + Math.round(Math.random() * 10000);    //随机函数名
    var xyUrl = "http://api.map.baidu.com/ag/coord/convert?from="+ type + "&to=4&x=" + point.lng + "&y=" + point.lat + "&callback=BMap.Convertor." + callbackName;
    //动态创建script标签
    load_script(xyUrl);
    BMap.Convertor[callbackName] = function(xyResult){
        delete BMap.Convertor[callbackName];    //调用完需要删除改函数
        var point = new BMap.Point(xyResult.x, xyResult.y);
        callback && callback(point);
    }
}

window.BMap = window.BMap || {};
BMap.Convertor = {};
BMap.Convertor.translate = translate;
})();


var bm = new BMap.Map("container");
var point = new BMap.Point(116.404844,39.923125);
bm.centerAndZoom(point, 15);
bm.addControl(new BMap.NavigationControl());

ggxy = function (){
    var x = document.getElementById("ggX").value;
    var y = document.getElementById("ggY").value;
    var ggPoint = new BMap.Point(x,y);
    BMap.Convertor.translate(ggPoint,2,translateCallback);
}

gpsxy = function (){
    var xx = document.getElementById("gpsX").value;
    var yy = document.getElementById("gpsY").value;
    var gpsPoint = new BMap.Point(xx,yy);
    BMap.Convertor.translate(gpsPoint,0,translateCallback);
}
translateCallback = function (point){
    bm.clearOverlays();
    var marker = new BMap.Marker(point);
    bm.addOverlay(marker);
    bm.setCenter(point);
    document.getElementById("baiduXY").innerHTML = point.lng + "," + point.lat;
}
</script>