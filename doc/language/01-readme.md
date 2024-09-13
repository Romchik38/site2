# readme

[!] This is only sketches to create a language system  

- html
- ISO 639
- headers
- php

## html

```html
<html lang="en">
<link rel="canonical" href="#">
<link rel="alternate" href="#" hreflang="en">
<meta charset="UTF-8">
```

## ISO 639

[doc](https://standards.iso.org/iso/639/ed-2/en/Access%20to%20the%20databases%20of%20the%20ISO%20639%20Language%20Code.pdf)  

[set1](https://www.loc.gov/standards/iso639-2/)  
[set2](http://www.loc.gov/standards/iso639-2/)  
[set3](https://iso639-3.sil.org/code_tables/639/data)  

Ukrainian:

- 639-1         uk  
- 639-2/639-5   ukr  
- 639-3         ukr  

English:

- 639-1         en  
- 639-2/639-5   eng  
- 639-3         eng  

## headers

Accept-Language: en-US,en;q=0.5  
Accept-Language: uk-UA,uk;q=0.8,en-US;q=0.5,en;q=0.3  

## php

- class Translate

  used inside other classes as dep  
  used inseid __()  

- __(value)

  create a fn, that will return a translated value  
  it must be visible in all included files  
  already have all info  
  *value* can be not only a phrase, but a key ( like some.key.to.find )  
