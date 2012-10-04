Codeigniter-uploadify
=====================

An implementation of uploadify with Codeigniter

This is a full 2.1.2 install of Codeigniter with Uploadify 3.1 integrated into it. This is a fairly convoluted procedure that I didn't want to spend hours explaining on the Codeigniter forums, so I just made a fresh Codeigniter install and dumped the necessary stuff in.

---

What was changed or is worth paying attention:
------------------------------------------


* MY_Session in the libraries folder

Uploadify's flash component uses the default php session. As the Codeigniter doesn't this creates an authentication problem. The extended session takes care of preserving the old session values while setting the new ones.

```
'formData'  : {'sessdata' : '<?php echo $this->session->get_encrypted_sessdata()?>'}
```

This is where you set the session variable and (optionally) any other post data you wish to send

BTW: I found this somewhere, but I can't seem to find it. I don't claim it as mine, kudos to whoever wrote it.

* setting the values for session in the config.php file

The session has to be encrypted and matching IP and user agent needs to be enabled.

* funky bug in Codeigniter 2.1 and above

You might notice

```
$config['allowed_types'] = '*';
```

which is a quick-and-dirty workaround. In any other case, you get a "this file type is not allowed" error. I've initially made this work in my project done with 2.0 and it didn't do this, so it is a new thing. Something like this was described on [stackoverflow](http://stackoverflow.com/questions/7495407/uploading-in-codeigniter-the-filetype-you-are-attempting-to-upload-is-not-allo) but that one was already fixed. I will debug this eventually, but for now, remember to write your own type handling. The one that uploadify does is client side and can be spoofed. The answer is in writing the MY_Upload class and rewriting the _file_mime_type function (beginning on like 1023) if anyone wants to do it, please send me a pull request.

I initially wanted to commit just the necessary files, but this will certainly seem more clear if i just do it like this.

---

Todo:

I'm planning to do an Amazon S3 example as well.