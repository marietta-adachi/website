■　{$title}　■

{$name_kana_sei} {$name_kana_mei}様

{Config::get("system.name")}をご利用いただきありがとうございます。
ご予約内容は以下の通りです。

*****************************************************************

予約日時：	{$reservation_datetime}

医療機関名：{$hospital.m_hospital_name}
所在地：	{$hospital.m_hospital_address}
			{$map_url}{*https://maps.google.co.jp/maps?q=27.164252,142.194328*}
電話番号：	{$hospital.m_hospital_tel}


来院歴：	{if $first_time}初診{else}再診{/if}
ご希望の診療／症状：{$symptom}

*****************************************************************

■注意事項
ご予約内容の確認やキャンセルは電話でご連絡ください。
無断キャンセルは医療機関へ大変な迷惑が掛かりますのでご遠慮ください。
診療内容により病院側の判断で診療順番が前後する可能性もございますので、予めご了承ください。

{Config::get("mail.caution_return")}
{Config::get("mail.caution_wrong")}
{Config::get("mail.caution_copy")}
{Config::get("mail.signature")}
