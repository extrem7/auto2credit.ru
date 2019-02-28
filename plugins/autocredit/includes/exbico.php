<?
$xml = "<?xml version=\"1.0\" encoding=\"windows-1251\" ?>
<credit_rating>
    <auth>
        <login></login>
        <password></password>
    </auth>
    <person>
        <lastname>$lastName</lastname>
        <firstname>$firstName</firstname>
    </person>
    <document>
        <number>$number</number>
        <series>$series</series>
    </document>
    <loan>
        <loantype>0</loantype>
        <loanamount>$amount</loanamount>
        <loanduration>61</loanduration>
    </loan>
    <istest>0</istest>
</credit_rating>";
return $xml;