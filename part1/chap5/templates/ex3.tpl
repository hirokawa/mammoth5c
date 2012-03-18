<html>
<head><title>条件分岐のサンプル</title></head>
<body>
{if isset($name)}
    {if $name == '鈴木'}
       <p> やあ! {$name}さん</p>
    {else}
       <p> {$name}さん、こんにちは.</p>       
    {/if}
{else}
 <p> ゲストさん、はじめまして!</p>	
{/if}
</body></html>
