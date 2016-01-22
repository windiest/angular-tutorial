function si_captcha_refresh(img_id,form_id,securimage_url,securimage_show_url) {
   var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
   var string_length = 16;
   var prefix = '';
   for (var i=0; i<string_length; i++) {
		var rnum = Math.floor(Math.random() * chars.length);
		prefix += chars.substring(rnum,rnum+1);
   }
  document.getElementById('si_code_' + form_id).value = prefix;

  var si_image_ctf = securimage_show_url + prefix;
  if(img_id == 'si_image_side_login') {
       document.getElementById('si_image_side_login').src = si_image_ctf;
  }else{
       document.getElementById('si_image_' + form_id).src = si_image_ctf;
  }
}