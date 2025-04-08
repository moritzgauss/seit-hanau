<?php

return function ($kirby, $site, $page) {
    $user = $kirby->user();
    
    if (!$user || !$user->isAdmin()) {
        go('/');
    }

    $articles = page('articles')->children()->filterBy('status', 'unlisted');

    if (get('approve')) {
        $article = $kirby->page(get('approve'));
        if ($article) {
            try {
                $article->changeStatus('listed');
                go($page->url());
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
    }

    return compact('articles', 'error');
};
