<?php
// $response['pagination']['prev'] = $this->Paginator->prev();
// $response['pagination']['next'] = $this->Paginator->next();
// $response['pagination']['first'] = $this->Paginator->first();
// $response['pagination']['last'] = $this->Paginator->last();
// $response['pagination']['current'] = $this->Paginator->current();
// $response['pagination']['hasNext'] = $this->Paginator->hasNext();
// $response['pagination']['hasPrev'] = $this->Paginator->hasPrev();
// $response['pagination']['hasPage'] = $this->Paginator->hasPage();
// $response['pagination']['numbers'] = $this->Paginator->numbers();
// $response['pagination']['counter'] = $this->Paginator->counter();
// $response['pagination']['params'] = $this->Paginator->params();
// $response['pagination']['sort'] = $this->Paginator->sort('id');
// $response['pagination']['link'] = $this->Paginator->link();
// $response['pagination']['param'] = $this->Paginator->param();
// $response['pagination']['meta'] = $this->Paginator->meta();
// $response['pagination']['options'] = $this->Paginator->options();
// TEST pagination
// $urlParams = $this->params['url'];
// unset($urlParams['url']);
// $this->Paginator->options(array('url' => array('?' => http_build_query($urlParams))));
$response['pagination'] = $this->Paginator->params();
echo json_encode($response, JSON_PRETTY_PRINT); 
?>