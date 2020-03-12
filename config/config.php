<?php
namespace config;
$alipayconfig=array(
    //应用ID,您的APPID。
    'app_id' => "2016101900721182",

    //商户私钥
    'merchant_private_key' => "MIIEowIBAAKCAQEAiS/z1ATccHXqFw9roajpJGDnx5AQZxyf56Nd+W63r3Ur/V9GLrYSBrEeRzQjWkKqO+V9GAk0waSekD9bCmwYnQo59gQb7rqkwEmb/1Xt01+7R0+z9em8LhztVjLYaMe+HvsK5ksmpRaPfzzaIEmxSVP8cTFB9GsyKtyZttK5B/zNsW/ZRsDgjen4zirPbE86PDAfUOltBILb0dWbynmHo5wjIs6VY8gpJvXvw5G3DzUOWZBnDvnWVrmNjt35KeXZg/ieEKkNKaH0tiIdiSU0d39N138bRkc5ubI2W9b3hIbfpw40onAAoSovIXyKIDLN4U6hDymYINilIe4Be8MI/QIDAQABAoIBACmNNqL/He2KKW72orkCOitklo9hWTaB+wTj/HCyUjx4luxVUSKQzwDr4KncZuDN1FXz+mGvWCVWwRgbuG19tC7MjCWxtOwn6AK9yNwboL8m/chpoa5YL0EgTdqP5/BEn5cunmyGUpwqKyh0u/SPnX0CTTHTo5Bub3GAA6bWSGjcelIrdZtSGeaywIUNc1zeeJ37qHmL8bSTj6z88HtxbGmHFp9tutEacCp87wNwa8BCxCPMJP7x+nbKGnhXFUr2cmAczpr/tnBjFypKnsnYWDHa0YLelcRVclGDAm7ypMWVk+MCrLjBzYvpLWehfAPUvcK7OiMwXX8AX26jRBfywgECgYEA748d9Sr71drgrXwuU1xnVbi4opTYX3QOG45oucpwwK6MkxIJAnS1KpWWph8bvfJyM83aHZO2ryTiwshL2phlpiy+tVQw71bUqQavGpLRGtPvkOdtjDRNNXi3fpG+xhX1JF+J2vTXGXpo288lUd3wO1rWQtgojZ9cjkXCksXTmz0CgYEAkpo8iXXRgpO28iEH2qsbb0ArB5Cz0b4YGQL1pYJyewjtndu8Y2le3MQ5BEDT+ZFd3f6reCdRX3dRu7Th2gjZtl0/Isy9oxjPudtuC5jWo+o/jeua5pnxrUqvthZt4e79h3qA3yQItrBuaIoLB81ATsxoxw9TxxBobdkrKkPXAMECgYEAx5DuYAOC8FD6wwukfAWKgDr2dVqSNlK0PfiQ/dXLwHio2ww3PTiEhAlCCvn3XnHO+aEPh3w6wAV2ctXxexVh+OFlriGI8pnfZ0AON5D/ad4MwSZKeHZJq7X5BxPbXaGFKtv8N8+oMa1sFVGnwV+mdYvi2qTAg9qyfENZKHRtJ/ECgYAT7c2e7ho+AvCSt7TGoA4JsJJo493d/FZwR/u2tSX03cDXfcB9TxyrLC2IC3wFaCJ3hCAxJD8mmCTPPIabSiq2ZLSpeWWqHzxVyqOKBgvfmn9rPoT/Jhw5b3a1bRUg6okiep+8NbzNgOxxX5qiQ9+jFpyDuuyrmepoTGZWx4QZwQKBgEOB0TefJeJmmaE9AcOE7t/Csl0EQDLEkl5+Ex3SebS1QM9N5dt7WL348QNXQ75yDuofuF4Xp28oJ68sk8YEnw3sQTk9LoGdjDw2QnOfFEwvjValys9DY7hmb6ryzygY9P8FxG1XEgS8Cn1VUPwm4LTpcibbrk39e5Wqxn1PNXXf",

    //异步通知地址
    'notify_url' => "http://101.200.32.25/notify_url.php",

    //同步跳转
    'return_url' => "http://101.200.32.25/return_url",

    //编码格式
    'charset' => "UTF-8",

    //签名方式
    'sign_type'=>"RSA2",

    //支付宝网关
    'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

    //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
    'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAlJ4GNjJDDYR7mDOZwvruu1pq5H0+w/0jiti8+ONyKtHIy4JmT05k6tGsGlI6W5K171UsnREMoPsSwpVs+E4knkr6Tx50crPhIpaOKsTirMKCU/xKJZIaUDYrD2nMkRhd+gU8iBiRilPVrxEoAEFYGDiaVGJijpiMA9G/8hMI1L1hnciSYYmfmuFxrmxXKYb+1WBv4akFbrYFosyiqZDEYuCpOwvarsq2U99qBwISAhVy5bEdyb8G4tJTI7NAJ2Y7EGZuBh6p+JkgEVoRinUhF9HHYT8EUIa5uibcVpYVaMGQBvyItez11oA8qTCx8BKbfW5TFEY/HmS4hLjO6RxLMwIDAQAB",
//                                  MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEApFuMQkmYp78lKkxoM8ZIBrf8ouuOQGfG5lYL0ZFwhxRmNFVqs4RTkLJgcNKvM/HwTpvzXWlz4l1MG4l/y06mJT7vcJW86tGNDdGVRQouJa5PpSktSVm07VzF+c3VgY7f6YcD1QuT+OJf6gezT42nd2fnfwBaCAM/zdfWfIlzlW139VAslRXkGCNDSseWZDqHiiVzhslh8NtaDpkTsdFLF4sajuDyIfRgA73t2SUbjKDiR0+7CvcHyDLVK+4MZQhKqSxZ3aTxt9ImFdlr1dTw1AqR/oth8PwY7R8cftrI8++SDuWthZlKGPhDFzfaBf6LE20DX7wT6Lv7oAQOLxqXGQIDAQAB

);

