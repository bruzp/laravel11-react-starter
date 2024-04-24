<?php

test('exam page can be displayed', function () {
    $response = $this->get(route('exams'));

    $response->assertStatus(200);
});
