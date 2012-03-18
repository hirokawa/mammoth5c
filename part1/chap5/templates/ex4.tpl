<html>
<head><title>ループ処理の例</title></head>
<body>
{foreach $users as $person}
 {$person@iteration}) {$person.name} : {$person.age}歳
 {if $person@last}<br />{else},{/if}
{foreachelse}
 データがありません.
{/foreach}
</body></html>
