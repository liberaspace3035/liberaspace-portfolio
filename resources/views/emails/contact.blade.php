@component('mail::message')
# お問い合わせがありました

以下の内容でお問い合わせを受け付けました。

## お問い合わせ内容

**お名前:** {{ $name }}

**メールアドレス:** {{ $email }}

**件名:** {{ $subject }}

**メッセージ:**
{{ $message }}

---

このメールは、Liberaspaceのお問い合わせフォームから送信されました。

@component('mail::button', ['url' => 'mailto:' . $email])
返信する
@endcomponent

@endcomponent

