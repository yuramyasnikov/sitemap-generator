<?php declare(strict_types=1);

namespace Yura\SitemapGenerator;

enum ChangeFreqEnum: string
{
    case Weekly = 'weekly';
    case Monthly = 'monthly';
}