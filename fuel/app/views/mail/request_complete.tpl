{$data.name}　様

{Config::get("system.name")}をご利用いただきありがとうございます。
下記内容でお問い合わせを承りました。
***************************************************************

{$contact_type_list[$data.contact_type]}

医院名：{$data.name}（{$data.name_kana}）

電話番号：{$data.tel}

メールアドレス：{$data.mail_address}

折り返し可能時間：{$data.free_time}

住所：{$data.address}

備考：
{$data.memo}

掲載申込：{if $data.apply}はい{else}いいえ{/if}

***************************************************************


{Config::get("mail.caution.wrong")}
{Config::get("mail.caution.return")}
{Config::get("mail.signature.cust")}