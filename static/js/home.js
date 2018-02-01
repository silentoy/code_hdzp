(function() {
  // var ajaxUrl = 'http://www.hdzp.com'
  // var ajaxUrl = ''

  //关闭弹层
  var $mask = $('.mask')
  var shutBox = $('.shutBox')
  var determine = $('.determine')
  var $cancel = $('.cancel')
  shutBox && shutBox.bind('click',function(){
    $mask.hide()
  })
  determine && determine.bind('click',function(){
    $mask.hide()
  })
  $cancel && $cancel.bind('click',function(){
    console.log($mask)
    $mask.hide()
  })


  //第一页 登录
  var loginUser = $('#loginUser')
  var loginPass = $('#loginPass')
  var loginCode = $('#loginCode')
  var login_error = $('.login-error')

  var loginButton = $('#loginButton')
  loginButton.bind('click', function() {
    $.ajax({
      url:'/index.php?c=login&m=onlogin',
      type: 'get',
      data: {
        name: loginUser.val(),
        password: loginPass.val(),
        code: loginCode.val(),
        referer: window.location.href
      },
      dataType: 'json',
      success: function(ele) {
        if (ele.status === 'ok') {
          window.location.href = ele.info.toUrl
        } else{
          login_error.show()
        }
      }
    })
  })

//注册页面


  // 第二页
// 注册页面
var regBtn = $('#regBtn')
var upImg = $('.upLoadImg')
var imgList = $('#imgList')
var regLicense = $('#regLicense')
var regLicenseNumber = $('#regLicenseNumber')
var tagList = $('#selectTags li')
var tagWrapper = $('#selectTags em')
var imgSrc = ''
var tags = $('#tags')
var tagid = [] //注册存储地点的标签
var tagidName = []
tagList && tagList.bind('click',function(event){
  var target = event.target
  var allow = false
  var number = 0
  $(tagid).each(function(index,ele){
    if(ele === $(target).data('id')){
      allow = true
      number = index
    }
  })
  //如果已经有了，删除掉
  if(allow){
    tagid.splice(number,1)
    tagidName.splice(number,1)
  } else{
    tagid.push($(target).data('id'))
    tagidName.push($(target).html())
  }
  //查看是否有选中的标签
  if(tagid.length){
    tagWrapper.html(tagidName.join(','))
    tagWrapper.addClass('active')
  } else{
    tagWrapper.html('请选择公司地点标签')
    tagWrapper.removeClass('active')
  }
  console.log(tagid,'tagid')
})
// 图片上传
upImg && upImg.bind('change',function(ele){
  var file = this.files[0]
  var reader = new FileReader();

  var formData = new FormData();

  formData.append("userfile",file);
  // 图片上传
  $.ajax({
    url:'/index.php?c=upload&m=onupload',
    type:'post',
    dataType:'json',
    processData: false,
    contentType: false,
    data:formData,
    success:function(res){
      console.log(res)
      if(res.status === 'ok'){
        // 赋值图片路径 并且创建预览
        imgSrc = res.info.url
        imgList.find('figure').html('<img src="' + res.info.url + '">')
        imgList.show()
      }
    }
  })
})
//计算公司简介字符
regLicense && regLicense.bind('input',function(){
  regLicenseNumber.html(regLicense.val().length)
})
// 点击注册
regBtn && regBtn.bind('click',function(){
  var formData = new FormData($('form').get(0))
  formData.append('license',imgSrc)
  formData.append('tagid',JSON.stringify(tagid))
  var $input = $('input')
  var o = {
    allow:true,
    text:''
  }

  // 验证必填
  $input.each(function(index, ele) {
    if(ele.type === 'text' && ele.value === '' && o.allow){
      o.allow = false
      console.log(ele)
      console.log($(ele).next())
      alert($(ele).next().html())
    }
    //验证手机号
    if(ele.name === 'tel' && ele.value != '' && !ele.value.match(/^1[0-9]{10}$/)){
      o.allow = false
      alert('请输入正确的手机号')
    }
    //验证邮箱
    if(ele.name === 'email' && ele.value != '' && !ele.value.match(/^[a-zA-Z0-9_-]+@([a-zA-Z0-9]+\.)+(com|cn|net|org)$/)){
      o.allow = false
      alert('请输入正确的邮箱地址')
    }
  })

  //验证选择地点标签
  if(!tagid.length && o.allow){
    o.allow = false
    alert('最少选择一个地点标签')
  }

  //验证是否上传营业执照
  if(imgSrc === '' && o.allow){
    o.allow = false
    alert('请上传营业执照')
  }

  //验证是否填写公司简介
  if(regLicense.val() === '' && o.allow){
    o.allow = false
    alert('请填写公司简介')
  }

  if(!o.allow){
    return
  }

  $.ajax({
    url:'/index.php?c=reg&m=onreg',
    data:$('form').serialize() + '&license=' + imgSrc + '&tagid=' + tagid.join(','),
    type:'post',
    dataType:'json',
    success:function(ele){
      if(ele.status === 'ok'){
        $('form input').val('')
        // 清空选择地点标签信息
        tagWrapper.html('')
        tagid = []
        tagidName = []

        //清除图片信息
        imgSrc = ''
        imgList.find('figure').html('')
        imgList.hide()

        //清除公司简介
        $('form textarea').val('')
        //显示弹层
        var regSuccess = $('#regSuccess')
        regSuccess.find('em').html(ele.info.password)
        regSuccess.show()
      } else{
        var errorPop = $('#errorPop')
        errorPop.find('.mask-content p').html(ele.msg)
        errorPop.show()
      }
    }
  })
})

//错误弹框
// var div = document.createElement('div')
// // div.innerHTML = '<div class="mask-content"><p>恭喜你，注册成功</p><p>您的密码是 K6YU8879  请牢牢记住或写道本子上</p><p>密码无法更改，忘记密码请联系客服: 15901071586</p><div class="footer"><span class="determine shutError">确定</span></div></div>'
// div.innerHTML = '<div class="title"><p>注册失败</p><span class="shutError">关</span></div><div class="mask-content"><p class="delete-text">抱歉，公司名称重复了</p><div class="footer"><span class="determine shutError">确定</span></div></div>'
// div.className="mask"
// div.id = 'mask'
// document.body.append(div)
// var shutError = $('.shutError')
// shutError.bind('click',function(){
//   $(div).remove()
// })


//   var form = $('#form')
//   form.bind('submit', function(event) {
//     event.preventDefault()
//       // var formData = new FormData(someFormElement);
//     console.log($("form").serialize())
//   })



  //第四页
  // 是否是面议
  var negotiable = $('#negotiable')
  var salary = $('#salary>input')
  negotiable.bind('change',function(){
    if(this.checked){
      salary.attr('disabled',true)
      salary.val('')
    }else{
      salary.attr('disabled',false)
    }
  })

  //发布职位
  var addPosition = $('#addPosition')
  var mask = $('#mask')
  //点击添加职位
  addPosition && addPosition.bind('click',function(){
    $.ajax({
      url:'/index.php?c=hr&m=onadd',
      data:$('form').serialize(),
      type:'post',
      dataType:'json',
      success:function(ele){
        if(ele.status === 'ok'){
        $('form input').each(function(index,ele){
          if(ele.type === 'text'){
            ele.value = ''
          }else if(ele.type === 'checkbox' || ele.type === 'radio'){
            ele.checked = false
          }
        })
        $('form textarea').val('')
          mask.show()
        }
        console.log(ele.data)
      }
    })
  })

  // 第五页
  // 点击删除按钮
  var handleMask = $('#handleMask')
  var handleOk = $('#handleOk')
  var handlePrompt = {}
  var handleBtn = $('.shelf')
  var current = null
  var handleParent = null
  var shelf = $('.shelf')
  var droptOk = $('#droptOk')
  var handleData = {}

  //点击操作按钮，显示弹层
  handleBtn && handleBtn.bind('click',function(){
    var $this = $(this)
    handleParent = $this.parent().parent()
    current = $this
    handleData = {
      id:handleParent.data('id'),
      status:$this.attr('data-type')
    }
    console.log(handleData,'handleData')
    handleMask.find('em').html($this.html())
    handleMask.show()
  })
  // 点击删除弹层确定按钮
  handleOk && handleOk.bind('click',function(){
    $.ajax({
      url:'/index.php?c=hr&m=positionUpdate',
      data:handleData,
      type:'get',
      dataType:'JSON',
      success:function(ele){
        if(ele.status === 'ok'){
          if(handleData.status == 1){
            handleParent.find('.status').html('已下线')
            current.html('上线').attr('data-type',2)
          }else if(handleData.status == 2){
            handleParent.find('.status').html('已上线')
            current.html('下架').attr('data-type',1)
          }else if(handleData.status == -1){
            handleParent.remove()
          }
        }
      }
    })
  })
})()