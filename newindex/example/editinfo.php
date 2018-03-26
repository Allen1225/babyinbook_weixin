<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;"/> 
    <title>我不怕上医院  - 信息填写</title>
    <style type="text/css">
        body{

 position: relative;
 font-size:20px;
        }

    select,button{padding:0.5em;}
    </style>
    <script type="text/javascript">
	    
    	function useOtherAdd(){
                var a = document.getElementById("otheraddress");
        
	        if(a.checked == false){
	        	var xx = document.getElementById("city_china");
	        	xx.style.display = "none"
                        var x = document.getElementsByClassName("isdisabled");
                        var i;
                        for (i = 0; i < x.length; i++) {
                         x[i].disabled = 'true';
                        }
                        var y = document.getElementsByClassName("isgrey");
                        var j;
                        for (j = 0; j < y.length; j++) {
                         y[j].style.color = 'grey';
                        }
                }else{
                	var xx = document.getElementById("city_china");
	        	xx.style.display = ""
                        var x = document.getElementsByClassName("isdisabled");
                        var i;
                        for (i = 0; i < x.length; i++) {
                         x[i].disabled = '';
                        }
                        var y = document.getElementsByClassName("isgrey");
                        var j;
                        for (j = 0; j < y.length; j++) {
                         y[j].style.color = 'black';
                        }
                }
        }
    	function check(){
		var x = document.getElementById("names").value;
		var y = document.getElementById("phone").value;
		var z = document.getElementById("nums").value;
		var r = /^\+?[1-9][0-9]*$/;
		if (x==null||x=="")
 		 {alert("请填写姓名");return false}
		if (y==null||y=="")
                 {alert("请填写电话");return false}
		if (z==null||z=="")
                 {alert("请填写数量");return false}
		     var re = /^[0-9]+.?[0-9]*$/;   //判断字符串是否为数字     //判断正整数 /^[1-9]+[0-9]*]*$/  
    
     if (!re.test(z))
    {
        alert("请填写正确的数量");
        return false;
     }
	}
  　
    </script>
    </head>
    
<body>
			<img src="../img/bg1.png" style="width:100%;height:200px;">
        <form onsubmit="return check();" action="jsapi.php" method="GET">
	<input type="hidden" name="pvid" value="<?php echo $_GET['pvid']; ?>" />
        <h3>请填写购买信息(必填)</h3>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;<font color="red">*</font>姓名 : <input id="names" style="position:relative;top:-4px;height:25px;width:200px;" type="text" name="name" /></p>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;<font color="red">*</font>电话 : <input id="phone" style="position:relative;top:-4px;height:25px;width:200px;" type="tel" name="phone" /></p>
       <p>&nbsp;&nbsp;&nbsp;&nbsp;<font color="red">*</font>购买数量：<input id="nums" style="height:25px;position:relative;top:-2px;width:100px;" type="tel" name="nums" /></p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;您的爱心购默认送货地址：上海儿童医学中心</p>
<p class="isgrey" style="color:grey">&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="otheraddress"  name="otheraddress" onchange="useOtherAdd()" value="otheraddress"  />使用其他地址</p>
  <fieldset style="border:none;margin:0px;padding:0px;" id="city_china">
<p class="isgrey" style="color:grey;-webkit-margin-before: 0em;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;姓名：<input name="oname" disabled="true" style="height:25px;position:relative;top:-2px;" type="text" class="isdisabled" /></p>
<p class="isgrey" style="color:grey">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;电话：<input name="ophone" disabled="true" style="height:25px;position:relative;top:-2px;" type="tel" 
class="isdisabled" /></p>	

   
    <p class="isgrey" style="color:grey">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;省份：<select name="shen"  class="province other isdisabled">
      <option>请选择</option>
    </select></p>
    <p class="isgrey" style="color:grey">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;城市：<select name="shi" disabled="true" class="city isdisabled">
      <option>请选择</option>
    </select></p>
    <p class="isgrey" style="color:grey">&nbsp;&nbsp;&nbsp;&nbsp;
地区：<select name="qu" disabled="true" class="area isdisabled">
      <option>请选择</option>
    </select></p>
 
<p class="isgrey" style="color:grey">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;详细地址：<input name="oaddress"  disabled="true" style="height:25px;position:relative;top:-2px;" type="text" class="isdisabled" /></p>         
                
   </fieldset>   



  

<script src="../js/jquery.min.js"></script>
<!-- <script src="http://cdn.staticfile.org/zepto/1.0/zepto.min.js"></script> -->
<script src="../js/jquery.cxselect.js"></script>
<script>
(function() {
  var urlChina = '../js/cityData.min.json';
  var urlGlobal = '../js/globalData.min.json';
  var dataCustom = [
    {'v': '1', 'n': '第一级 >', 's': [
      {'v': '2', 'n': '第二级 >', 's': [
        {'v': '3', 'n': '第三级 >', 's': [
          {'v': '4', 'n': '第四级 >', 's': [
            {'v': '5', 'n': '第五级 >', 's': [
              {'v': '6', 'n': '第六级 >'}
            ]}
          ]}
        ]}
      ]}
    ]},
    {'v': 'test number', 'n': '测试数字', 's': [
      {'v': 'text', 'n': '文本类型', 's': [
        {'v': '4', 'n': '4'},
        {'v': '5', 'n': '5'},
        {'v': '6', 'n': '6'},
        {'v': '7', 'n': '7'},
        {'v': '8', 'n': '8'},
        {'v': '9', 'n': '9'},
        {'v': '10', 'n': '10'}
      ]},
      {'v': 'number', 'n': '数值类型', 's': [
        {'v': 11, 'n': 11},
        {'v': 12, 'n': 12},
        {'v': 13, 'n': 13},
        {'v': 14, 'n': 14},
        {'v': 15, 'n': 15},
        {'v': 16, 'n': 16},
        {'v': 17, 'n': 17}
      ]}
    ]},
    {'v': 'test boolean','n': '测试 Boolean 类型', 's': [
      {'v': true ,'n': true},
      {'v': false ,'n': false}
    ]},
    {v: 'test quotes', n: '测试属性不加引号', s: [
      {v: 'quotes', n: '引号'}
    ]},
    {v: 'test other', n: '测试奇怪的值', s: [
      {v: '[]', n: '数组（空）'},
      {v: [1,2,3], n: '数组（数值）'},
      {v: ['a','b','c'], n: '数组（文字）'},
      {v: new Date(), n: '日期'},
      {v: new RegExp('\\d+'), n: '正则对象'},
      {v: /\d+/, n: '正则直接量'},
      {v: {}, n: '对象'},
      {v: document.getElementById('custom_data'), n: 'DOM'},
      {v: null, n: 'Null'},
      {n: '未设置 value'}
    ]},
    {'v': '' , 'n': '无子级'}
  ];

  $.cxSelect.defaults.url = urlChina;

  // 默认
  $('#city_china').cxSelect({
    selects: ['province', 'city', 'area']
  });

  // 设置默认值及选项标题
  $('#city_china_val').cxSelect({
    selects: ['province', 'city', 'area'],
    emptyStyle: 'none'
  });

  // 全球主要国家城市联动
  $('#global_location').cxSelect({
    url: urlGlobal,
    selects: ['country', 'state', 'city', 'region'],
    emptyStyle: 'none'
  });

  // 自定义选项
  $('#custom_data').cxSelect({
    selects: ['first', 'second', 'third', 'fourth', 'fifth'],
    // required: true,
    jsonValue: 'v',
    data: dataCustom
  });

  // API 接口
  var apiBox = $('#api_data');
  var cxSelectApi;

  apiBox.cxSelect({
    selects: ['province', 'city', 'area']
  }, function(api) {
    cxSelectApi = api;
  });

  // cxSelectApi = $.cxSelect(apiBox, {
  //   selects: ['province', 'city', 'area']
  // });

  $('body').on('click', 'button', function() {
    var _name = this.name;
    var _value = this.value;

    switch (_name) {
      case 'attach':
        cxSelectApi.attach();
        break;

      case 'detach':
        cxSelectApi.detach();
        break;

      case 'clear':
        cxSelectApi.clear();
        break;

      case 'required':
        cxSelectApi.setOptions({
          required: _value == 1 ? false : true
        });
        this.value = _value == 1 ? 0 : 1;
        break;

      case 'emptyStyle':
        if (_value === 'none') {
          _value = 'hidden';
        } else if (_value === 'hidden') {
          _value = '';
        } else {
          _value = 'none';
        };
        cxSelectApi.setOptions({
          emptyStyle: _value
        });
        this.value = _value;
        break;

      case 'firstTitle':
        _value = _value === '请选择' ? '选择吧' : '请选择';
        cxSelectApi.setOptions({
          firstTitle: _value
        });
        this.value = _value;
        break;

      case 'setSelect':
        cxSelectApi.setOptions({
          selects: _value === 'a' ? ['province', 'city', 'area'] : ['first', 'second', 'third', 'fourth', 'fifth']
        });
        this.value = _value === 'a' ? 'b' : 'a';
        break;

      case 'setData':
        if (_value === 'china' || _value === 'global') {
          // $.ajax({
          //   url: this.value === 'china' ? urlChina : urlGlobal,
          //   type: 'GET',
          //   dataType: 'json'
          // }).done(function(data, textStatus, jqXHR) {
            cxSelectApi.setOptions({
              url: this.value === 'china' ? urlChina : urlGlobal,
              // data: data
            });
          // }).fail(function(jqXHR, textStatus, errorThrown) {
          // });

        } else if (this.value === 'custom') {
          cxSelectApi.setOptions({
            data: dataCustom
          });
        };
        break;

      // not default
    };
  });
})();
</script>           
                
        <h3>补充个人信息(选填)</h3>        
                
                <p>&nbsp;&nbsp;&nbsp;&nbsp;性别：<input name="sex" type="radio" value="male" />男  <input name="sex" type="radio" value="female" />女</p>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;年龄：<input style="position:relative;top:-4px;height:25px;width:80px;" type="tel" name="age" />&nbsp;&nbsp;&nbsp;&nbsp;职业：<input style="position:relative;top:-4px;height:25px;width:80px;" type="text" name="job" /></p>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;微信：<input style="position:relative;top:-4px;height:25px;width:200px;" type="text" name="wechat" /></p>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;邮箱：<input style="position:relative;top:-4px;height:25px;width:200px;" type="text" name="mail" /></p>
                <p><div style="position:relative;display: inline;top:-80px;">&nbsp;&nbsp;&nbsp;&nbsp;留言：</div><textarea style="position:relative;width:200px;height:100px;" name="message" ></textarea></p>
                <input onclick="window.history.go(-1);" type="button"  style="position:absolute;left:22.5%;width:25%; height:30px; border-radius: 15px;background-color:#f7931e; border:0px #FE6714 solid; cursor: pointer;  color:black;  font-size:20px;" value="上一步" />
                <input type="submit"  style="position:absolute;left:52.5%;width:25%; height:30px; border-radius: 15px;background-color:#f7931e; border:0px #FE6714 solid; cursor: pointer;  color:black;  font-size:20px;" value="下一步" />
<br/><br/></form>
<script>
	useOtherAdd();
</script>
</body>
</html>

