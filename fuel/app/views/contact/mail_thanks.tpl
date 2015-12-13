{$data.name}　様

{Config::get("system.name")}をご利用いただきありがとうございます。
下記内容でお問い合わせを承りました。
***************************************************************

{$contact_type_list[$data.contact_type]}

お名前：{$data.name}（{$data.name_kana}）

電話番号：{$data.tel}

メールアドレス：{$data.mail_address}

内容：
{$data.contact_detail}

***************************************************************


{Config::get("mail.caution.wrong")}
{Config::get("mail.caution.return")}
{Config::get("mail.signature.cust")}