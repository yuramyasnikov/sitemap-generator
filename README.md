## Для для использования библиотеки в своем проекте нужно выполнить:
```bash
composer require yuramyasnikov/sitemap-generator
```

#### Пример.
### Создайте файл index.php с таким содержимым:
```php

use Yura\SitemapGenerator\ChangeFreqEnum;
use Yura\SitemapGenerator\Page;
use Yura\SitemapGenerator\SiteMapGeneratorFactory;

require_once 'vendor/autoload.php';

// Список страниц
$pages = [
    new Page('http://example.com', new \DateTimeImmutable(), ChangeFreqEnum::Monthly, 1),
    new Page('http://example.com/about', new \DateTimeImmutable(), ChangeFreqEnum::Monthly, 1),
    new Page('http://example.com/contacts'),
];

// Генерируем файл по указаному адресу
SiteMapGeneratorFactory::create('xml')->generate($pages, 'public_html/sitemap.xml');

```