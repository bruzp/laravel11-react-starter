<?php

it('display the index', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
