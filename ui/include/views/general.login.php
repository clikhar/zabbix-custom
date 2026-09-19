<?php
/*
** Copyright (C) 2001-2026 Zabbix SIA
**
** This program is free software: you can redistribute it and/or modify it under the terms of
** the GNU Affero General Public License as published by the Free Software Foundation, version 3.
**
** This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
** without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
** See the GNU Affero General Public License for more details.
**
** You should have received a copy of the GNU Affero General Public License along with this program.
** If not, see <https://www.gnu.org/licenses/>.
**/


/**
 * @var CView $this
 */

define('ZBX_PAGE_NO_HEADER', 1);
define('ZBX_PAGE_NO_FOOTER', 1);
define('ZBX_PAGE_NO_MENU', true);
define('ZBX_PAGE_NO_JSLOADER', true);

require_once dirname(__FILE__).'/../page_header.php';
$error = null;

if ($data['error']) {
	$message = trim(preg_replace('/\[.*\]/', '', $data['error']['message']));
	$error = (new CDiv($message))->addClass(ZBX_STYLE_RED);
}

$guest = $data['guest_login_url']
	? (new CListItem([_('or'), ' ', new CLink(_('sign in as guest'), $data['guest_login_url'])]))
		->addClass(ZBX_STYLE_SIGN_IN_TXT)
	: null;

$http_login_link = $data['http_login_url']
	? (new CListItem(new CLink(_('Sign in with HTTP'), $data['http_login_url'])))->addClass(ZBX_STYLE_SIGN_IN_TXT)
	: null;

$saml_login_link = $data['saml_login_url']
	? (new CListItem(new CLink(_('Sign in with Single Sign-On (SAML)'), $data['saml_login_url'])))
		->addClass(ZBX_STYLE_SIGN_IN_TXT)
	: null;

global $ZBX_SERVER_NAME;

$server_name = (isset($ZBX_SERVER_NAME) && $ZBX_SERVER_NAME !== '')
	? $ZBX_SERVER_NAME
	: 'NGP Division, Central Railway';

(new CDiv([
	(new CTag('main', true, [
		(new CDiv([
			(new CDiv(makeLogo(LOGO_TYPE_NORMAL)))->addClass('cr-login-brand-logo'),
			(new CDiv($server_name))->addClass('cr-login-brand-name'),
			(new CDiv('Connecting People'))->addClass('cr-login-brand-tagline'),
			(new CDiv('Moving the Nation'))->addClass('cr-login-brand-tagline'),
			(new CDiv('सुरक्षित रेल  •  समृद्ध भारत'))->addClass('cr-login-brand-hindi'),
			(new CDiv('SAFER RAILWAYS  •  PROSPEROUS INDIA'))->addClass('cr-login-brand-footer')
		]))->addClass('cr-login-brand'),

		(new CDiv([
			(new CDiv([
				(new CDiv(makeLogo(LOGO_TYPE_NORMAL)))->addClass(ZBX_STYLE_SIGNIN_LOGO),
				(new CDiv($server_name))->addClass('cr-login-card-title'),
				(new CDiv('Zabbix Network Monitoring System'))->addClass('cr-login-card-subtitle'),
				(new CForm())
					->setAttribute('aria-label', _('Sign in'))
					->addItem(hasRequest('request') ? new CVar('request', getRequest('request')) : null)
					->addItem(
						(new CList())
							->addItem([
								new CLabel(_('Username'), 'name'),
								(new CTextBox('name'))->setAttribute('autofocus', 'autofocus'),
								$error
							])
							->addItem([
								new CLabel(_('Password'), 'password'),
								(new CPassBox('password'))->setAttribute('autocomplete', 'off')
							])
							->addItem(
								(new CCheckBox('autologin'))
									->setLabel(_('Remember me for 30 days'))
									->setChecked($data['autologin'])
							)
							->addItem(new CSubmit('enter', _('Sign in')))
							->addItem($guest)
							->addItem($http_login_link)
							->addItem($saml_login_link)
					)
			]))->addClass(ZBX_STYLE_SIGNIN_CONTAINER)->addClass('cr-login-card')
		]))->addClass('cr-login-form-area'),

		(new CDiv())->addClass('cr-login-rail-scene')
	]))->addClass('cr-login-main'),

	(new CDiv([
		(new CLink(_('Help'), CBrandHelper::getHelpUrl()))
			->setTarget('_blank')
			->addClass(ZBX_STYLE_GREY)
			->addClass(ZBX_STYLE_LINK_ALT),
		CBrandHelper::isRebranded() ? null : [NBSP(), NBSP(), BULLET(), NBSP(), NBSP()],
		CBrandHelper::isRebranded()
			? null
			: (new CLink(_('Support'), getSupportUrl(CWebUser::getLang())))
				->setTarget('_blank')
				->addClass(ZBX_STYLE_GREY)
				->addClass(ZBX_STYLE_LINK_ALT)
	]))->addClass(ZBX_STYLE_SIGNIN_LINKS)
]))
	->addClass(ZBX_STYLE_LAYOUT_WRAPPER)
	->addClass('cr-login-page')
	->show();
?>
<style>
.cr-login-page {
	min-height: 100vh;
	width: 100%;
	background: #063a60;
	color: #123d5b;
	overflow: hidden;
}

.cr-login-main {
	position: relative;
	display: grid;
	grid-template-columns: minmax(270px, 31%) minmax(430px, 48%) minmax(260px, 21%);
	min-height: calc(100vh - 52px);
	background: linear-gradient(135deg, #07517f 0%, #0b5f8f 38%, #dcecf6 38.1%, #f7fafc 62%, #0a4d78 62.1%, #062d4b 100%);
}

.cr-login-brand {
	position: relative;
	z-index: 4;
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
	padding: 42px 30px;
	text-align: center;
	color: #fff;
	background: linear-gradient(180deg, rgba(2,45,77,.88), rgba(4,68,108,.93));
}

.cr-login-brand-logo {
	width: 150px;
	margin-bottom: 24px;
}

.cr-login-brand-logo img,
.cr-login-brand-logo svg {
	width: 100%;
	height: auto;
}

.cr-login-brand-name {
	max-width: 260px;
	font-size: 28px;
	font-weight: 700;
	line-height: 1.12;
}

.cr-login-brand-tagline {
	font-size: 19px;
	font-style: italic;
	line-height: 1.35;
	letter-spacing: .2px;
}

.cr-login-brand-tagline:first-of-type {
	margin-top: 34px;
}

.cr-login-brand-hindi {
	margin-top: 50px;
	font-size: 19px;
	font-weight: 600;
}

.cr-login-brand-footer {
	margin-top: 10px;
	font-size: 12px;
	letter-spacing: 1.1px;
	opacity: .9;
}

.cr-login-form-area {
	position: relative;
	z-index: 5;
	display: flex;
	align-items: center;
	justify-content: center;
	padding: 50px 35px;
	background: rgba(244, 249, 252, .12);
}

.cr-login-card {
	width: min(520px, 100%);
	margin: 0 !important;
	padding: 38px 42px 32px !important;
	background: rgba(255,255,255,.98) !important;
	border: 1px solid rgba(24, 73, 105, .14) !important;
	border-radius: 18px !important;
	box-shadow: 0 22px 65px rgba(0, 35, 60, .26);
}

.cr-login-card .signin-logo {
	margin-bottom: 13px;
}

.cr-login-card .signin-logo img,
.cr-login-card .signin-logo svg {
	max-width: 108px;
	max-height: 108px;
	width: auto;
	height: auto;
}

.cr-login-card-title {
	text-align: center;
	font-size: 25px;
	font-weight: 700;
	line-height: 1.12;
	color: #123f61;
}

.cr-login-card-subtitle {
	margin: 8px 0 25px;
	text-align: center;
	font-size: 14px;
	color: #55748c;
}

.cr-login-card form {
	margin-top: 5px;
}

.cr-login-card form ul li {
	padding-top: 13px;
}

.cr-login-card form label {
	color: #173e5b;
	font-weight: 500;
}

.cr-login-card form input[type="text"],
.cr-login-card form input[type="password"] {
	box-sizing: border-box;
	width: 100%;
	min-height: 45px;
	padding: 10px 13px;
	border: 1px solid #bfd1df;
	border-radius: 8px;
	background: #fff;
}

.cr-login-card form input[type="text"]:focus,
.cr-login-card form input[type="password"]:focus {
	border-color: #1879b5;
	box-shadow: 0 0 0 3px rgba(24,121,181,.12);
	outline: none;
}

.cr-login-card form button {
	min-height: 46px;
	margin-top: 11px;
	border-radius: 8px;
	background: #0877b5;
	font-size: 15px;
	font-weight: 600;
	box-shadow: 0 7px 18px rgba(8,119,181,.22);
}

.cr-login-card form button:hover {
	background: #06669b;
}

.cr-login-rail-scene {
	position: relative;
	min-height: 100%;
	background-image:
		linear-gradient(90deg, rgba(6,45,73,.18), rgba(6,45,73,.05)),
		url("../rebranding/indian-railways-login-background.svg");
	background-size: cover;
	background-position: center;
	box-shadow: inset 24px 0 45px rgba(2,35,57,.15);
}

.cr-login-rail-scene::before {
	content: "Indian Railways\A Lifeline of the Nation";
	white-space: pre;
	position: absolute;
	top: 8%;
	right: 7%;
	max-width: 260px;
	color: rgba(255,255,255,.94);
	font-size: clamp(20px, 2vw, 31px);
	font-weight: 700;
	line-height: 1.18;
	text-align: right;
	text-shadow: 0 2px 10px rgba(0,0,0,.25);
}

.cr-login-rail-scene::after {
	content: "People  •  Progress  •  Prosperity";
	position: absolute;
	right: 7%;
	bottom: 5%;
	color: rgba(255,255,255,.9);
	font-size: 13px;
	font-weight: 600;
	letter-spacing: .4px;
}

.cr-login-links,
.cr-login-page .signin-links {
	position: relative;
	z-index: 10;
	margin: 0;
	padding: 10px 20px 14px;
	background: #062d4b;
	color: rgba(255,255,255,.72);
}

.cr-login-page .signin-links a {
	color: rgba(255,255,255,.82) !important;
}

.cr-login-page .footer {
	background: #062d4b;
}

@media (max-width: 1050px) {
	.cr-login-main {
		grid-template-columns: 240px minmax(420px, 1fr);
		background: #eaf3f8;
	}

	.cr-login-rail-scene {
		display: none;
	}

	.cr-login-brand {
		padding: 30px 20px;
	}

	.cr-login-brand-logo {
		width: 120px;
	}
}

@media (max-width: 700px) {
	.cr-login-main {
		display: block;
		min-height: calc(100vh - 50px);
		background: #eaf3f8;
	}

	.cr-login-brand {
		padding: 24px 20px 20px;
	}

	.cr-login-brand-logo {
		width: 92px;
		margin-bottom: 12px;
	}

	.cr-login-brand-name {
		font-size: 22px;
	}

	.cr-login-brand-tagline,
	.cr-login-brand-hindi,
	.cr-login-brand-footer {
		display: none;
	}

	.cr-login-form-area {
		padding: 20px 14px 30px;
	}

	.cr-login-card {
		padding: 28px 22px 25px !important;
	}

	.cr-login-rail-scene {
		display: none;
	}
}
</style>
</body>
