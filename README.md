#Simple Akismet PHP client

Very simple modern PHP implementation of Akismet spam check service.

###Install
```
composer require tvaliasek/simple-php-akismet
```

###Use
``` php
use SimpleAkismet\Client;
use SimpleAkismet\DataObject\Message;
use SimpleAkismet\Exception\AkismetException;
use SimpleAkismet\Exception\InvalidKeyException;
use SimpleAkismet\Exception\InvalidStatusCodeException;

/* 
* Client covers all four API methods: 
* verifyKey, checkSpam, submitSpam and submitHam 
*/
$client = new Client(
    'yourAkismetApiKey',
    'https://www.example.com/',
    new \GuzzleHttp\Client()
);

$message = (new Message())
    ->setBlog('https://www.example.com/')
    ->setCommentAuthorEmail('john@doe.com')
    ->setCommentContent('Cheap viagra for sale on: www.foo.com')
    ->setCommentDateGmt(new \DateTime());
    // all available fields has their own setter and getter

try {
    if ($client->checkSpam($message)) {
        // do something with spam message
    }
} catch (AkismetException | InvalidKeyException | InvalidStatusCodeException $e) {
    // ...
}
```