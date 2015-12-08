<?php

return [
// <editor-fold defaultstate='collapsed' desc='common'>
    'system' => [
	'code' => 'WEBSITE',
	'name' => 'WEBSITE',
    ],
    'base_url' => '/',
    'const' => [
	'query_cache_seconds' => 1 * 60 * 60,
    ],
    'dir' => [
	'root' => '/var/www/website/public/',
    ],
    'host' => [
    ],
    'mail' => [
	'account' => [
	    'help' => [
		'addr' => 'help@marietta.co.jp',
		'name' => 'help',
	    ],
	    'support' => [
		'addr' => 'support@marietta.co.jp',
		'name' => 'support',
	    ],
	    'admin' => [
		'addr' => 'admin@marietta.co.jp',
		'name' => 'admin',
	    ],
	],
	'prefix' => '【WEBSITE】',
	'caution' => [
	    'wrong' => '※本メールに心当たりのない方は、お手数ですが下記までご連絡いただきますようお願いいたします。',
	    'return' => '※本メールアドレスには返信できませんのでご注意ください。',
	    'copy' => '※本メールの無断掲載、複製を禁じます。',
	    'url' => '※URLがクリックできない場合、URLをコピーしてお使いのブラウザに貼り付けてアクセスして下さい。',
	],
	'signature' => [
	    'cust' =>
	    '―――――――――――――――――――――――――――――――――――――――――――――――\r\n'.
	    '株式会社マリエッタ\r\n'.
	    '所在地：　〒999-9999 東京都台東区\r\n'.
	    'Mail： help@marietta.co.jp\r\n'.
	    'Tel ： 99-9999-9999\r\n'.
	    '―――――――――――――――――――――――――――――――――――――――――――――――\r\n',
	    'admin' =>
	    '―――――――――――――――――――――――――――――――――――――――――――――――\r\n'.
	    'WEBSITE\r\n'.
	    '―――――――――――――――――――――――――――――――――――――――――――――――\r\n',
	],
    ],
// </editor-fold>
// <editor-fold defaultstate='collapsed' desc='site'>
    'site' => [
	'display_meta' => false,
	'common_title' => 'WEBSITE',
	'common_keywords' => [],
	'common_description' => '',
	/*
	 * 画面毎の固有値
	 * key：テンプレート名
	 * title：$commonTitleの前に付与
	 * keywords：$commonKeywordsの任意の場所に挿入
	 * description：$commonDescriptionの前に付与
	 */
	'screen_info' => [
	    '404' => ['', [null, []], '',],
	    'index' => ['歯医者・病院の予約・検索', [null, []], '',],
	    'about' => ['について', [null, []], '',],
	    'hospital' => ['', [null, []], '',],
	    'hospital_detail' => ['', [null, []], '',],
	    'contact_edit' => ['お問い合わせ', [null, []], '',],
	    'contact_confirm' => ['お問い合わせ内容確認', [null, []], '',],
	    'contact_complete' => ['お問い合わせ送信完了', [null, []], '',],
	    'error' => ['サーバエラー', [null, []], '',],
	],
	'auth' => [
	    'on' => [
	    ],
	    'off' => [
	    ],
	],
	'ssl' => [
	    'on' => [// or off
		'contact_index',
		'contact_confirm',
		'contact_do',
	    ],
	],
	'page_limit' => [
	    'hospital' => 15,
	    'blog' => 3,
	],
	'expire' => [
	    'xx' => 30 * 24 * 60 * 60,
	],
	'const' => [
	    'search_radius' => [
		500 => '500m圏内',
		1000 => '1km圏内',
		5000 => '5km圏内',
	    ],
	],
    ],
// </editor-fold>
// <editor-fold defaultstate='collapsed' desc='admin'>
    'admin' => [
	'common_title' => '管理｜WEBSITE',
	'common_keywords' => [],
	'common_description' => '管理｜WEBSITE',
	/*
	 * 画面毎の固有値
	 * key：テンプレート名
	 * title：$commonTitleの前に付与
	 * keywords：$commonKeywordsの任意の場所に挿入
	 * description：$commonDescriptionの前に付与
	 */
	'screen_info' => [
	    'admin/index' => ['トップ', [null, []], '',],
	    'admin/auth' => ['ログイン', [null, []], '',],
	    'admin/user' => ['一覧', [null, []], '',],
	    'admin/user_edit' => ['入力', [null, []], '',],
	    'admin/user_confirm' => ['入力内容確認', [null, []], '',],
	    'admin/user_do' => ['更新完了', [null, []], '',],
	    'admin/setting' => ['設定', [null, []], '',],
	],
	'auth' => [
	    'on' => [
	    ],
	    'off' => [
		'admin_auth_index',
		'admin_auth_login',
	    ],
	],
	'ssl' => [
	    'on' => [// or off
	    ],
	],
	// ページ関連
	'page_limit' => [
	    'hospital' => 30,
	    'review' => 30,
	],
    ],
// </editor-fold>
];
