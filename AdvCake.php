<?php 
echo revertCharacters("Привет! Давно не виделись.").'<br>';
test();

function revertCharacters($string)
{
    $string=mb_str_split($string); //строку в массив
    foreach($string as $letter)
    {
        $next=next($string);
        if(!(IntlChar::ispunct($letter) || IntlChar::isspace($letter) || IntlChar::isdigit($letter)))  //если буква
            {
                $word1[]=$letter;                           //слово, в котором будем менять порядок букв
                if(IntlChar::isUpper($letter))
                    $Uppers[]=array_key_last($word1);   //сохраняем позиции, на которых находятся заглавные буквы
            }
        if(IntlChar::ispunct($letter) || IntlChar::isspace($letter) || IntlChar::isdigit($letter) || !$next )   //если не буква или последний символ строки
        {
            if(isset($word1))
            {
                $word1=array_reverse($word1);   //переворачиваем массив
                if(isset($Uppers))  //сохраняем правильный регистр
                {                   
                    for($i=0; $i<count($word1); $i++)
                    {
                        if(array_search($i, $Uppers)!==false)
                            $word1[$i]=IntlChar::toupper($word1[$i]);  
                        else
                            $word1[$i]=IntlChar::tolower($word1[$i]);
                    }
                    unset($Uppers);
                }
                $word1=implode($word1); //массив в строку
                if(!isset($result))
                    $result="";
                $result.=$word1;
                unset($word1);
            }
            if(IntlChar::ispunct($letter) || IntlChar::isspace($letter) || IntlChar::isdigit($letter))  //если не буква
                $result.=$letter;          //сохраняем знак препинания
        }
    }
    return $result;
}

function testRevertRussian()
{
    $str=revertCharacters('Привет! Давно не виделись.');
    if ($str=='Тевирп! Онвад ен ьсиледив.') 
        return true;
    else 
        return false;
}
function testRevertEnglish()
{
    $str=revertCharacters("Hi! Did not see you for a long time");
    if ($str=="Ih! Did ton ees uoy rof a gnol emit") 
        return true;
    else 
        return false;
}
function testRevertNumbers()
{
    $str=revertCharacters("Привет, 4ел. Давно не виделись");
    if ($str=="Тевирп, 4ле. Онвад ен ьсиледив") 
        return true;
    else 
        return false;
}
function test()
{
    $r=testRevertRussian();
    $e=testRevertEnglish();
    $n=testRevertNumbers();
    if($r && $e && $n)
    {   
        echo "<br>Тесты пройдены, ошибок нет";
        return true;
    }
    else
    {   
        echo "<br>Внимание ошибка! В тесте ";
        echo (!$r)?('на русские буквы '):('');
        echo (!$e)?('на английские буквы '):('');
        echo (!$n)?('на числа '):('');
        return false;
    }
}