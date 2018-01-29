(function() {
  // var ajaxUrl = 'http://www.hdzp.com'
  // var ajaxUrl = ''
  // 第一页

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

  // 第二页
// 图片上传
var upImg = $('#upImg')
var imgList = $('#imgList')
upImg.bind('change',function(ele){
  var file = this.files[0]
  var reader = new FileReader();

  var formData = new FormData();

  formData.append("userfile",file);
  console.log(upImg.val(),'upImg.val()')

  console.log(formData,'formData')
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
        var figure = document.createElement('figure')
        figure.innerHTML = '<img src="' + res.info.url + '">'
        imgList.append(figure)
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
  var addPositionBtn = $('#addPositionBtn')
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
  //点击确定，关闭弹层
  addPositionBtn && addPositionBtn.bind('click',function(){
    mask.hide()
  })

  // 第五页
  // 点击删除按钮
  var mask = $('#mask')
  var maskTitle = $('#mask .title p')
  var maskContent = $('#mask .mask-content p')
  var deleteBtn = $('.delete')
  var determine = $('#determine')
  var shelf = $('.shelf')
  var shutBox = $('.shutBox')
  //点击删除按钮，显示弹层
  deleteBtn && deleteBtn.bind('click',function(){
    maskTitle.html('职位删除')
    maskContent.html('确定要删除吗？')
    mask.show()
    determine.attr('data-id',$(this).data('id'))
    determine.attr('data-type','remove')
  })
  //点击下架
  shelf && shelf.bind('click',function(){
    maskTitle.html('职位下架')
    maskContent.html('确定要下架吗？')
    mask.show()
    determine.attr('data-id',$(this).data('id'))
    determine.attr('data-type','shelf')
  })

  //点击确定 && 删除
  determine && determine.bind('click',function(){
    let type = determine.data('id')
    //下架
    if(type === 'shelf'){

    }else {
    // 删除

    }
    $.ajax({
      url:'',
      type:'post',
      data:'',
      dataType:'json',
      success:function(ele){

      }
    })
  })
  // 点击关闭弹窗
  shutBox && shutBox.bind('click',function(){
    mask.hide()
  })
})()