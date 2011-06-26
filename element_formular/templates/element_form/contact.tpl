<contactform>
<form name="formContact" method="post" action="%%formaction%%" accept-charset="UTF-8">
	%%formular_fehler%%
	<div><label for="absender_name">%%lang_formContact_name%%</label><input type="text" name="absender_name" id="absender_name" value="%%absender_name%%" class="inputText" /></div><br />
	<div><label for="absender_email">%%lang_formContact_email%%</label><input type="text" name="absender_email" id="absender_email" value="%%absender_email%%" class="inputText" /></div><br />
	<div><label for="absender_nachricht">%%lang_formContact_message%%</label><textarea name="absender_nachricht" id="absender_nachricht" class="inputTextarea">%%absender_nachricht%%</textarea></div><br /><br />
	<div><label for="kajonaCaptcha_contact"></label><span id="kajonaCaptcha_contact"><script type="text/javascript">KAJONA.portal.loadCaptcha('contact', 180);</script></span> (<a href="#" onclick="KAJONA.portal.loadCaptcha('contact', 180); return false;">%%lang_commons_captcha_reload%%</a>)</div><br />
	<div><label for="form_captcha">%%lang_commons_captcha%%</label><input type="text" name="form_captcha" id="form_captcha" class="inputText" autocomplete="off" /></div><br /><br />
	<div><label for="Submit"></label><input type="submit" name="Submit" value="%%lang_formContact_send%%" class="button" /></div><br />
</form>
</contactform>

<email>
Folgende Anfrage wurde ueber das Kontaktformular erstellt:

%%lang_formContact_name%%
	%%absender_name%%
%%lang_formContact_email%%
	%%absender_email%%
%%lang_formContact_message%%
	%%absender_nachricht%%
</email>

<errors>
%%lang_formContact_errors%%<br />
<ul>%%liste_fehler%%</ul>
</errors>

<errorrow>
<li>%%error%%</li>
</errorrow>