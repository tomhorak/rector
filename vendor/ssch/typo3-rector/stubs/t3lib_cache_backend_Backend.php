<?php

namespace RectorPrefix20211030;

if (\class_exists('t3lib_cache_backend_Backend')) {
    return;
}
class t3lib_cache_backend_Backend
{
}
\class_alias('t3lib_cache_backend_Backend', 't3lib_cache_backend_Backend', \false);
