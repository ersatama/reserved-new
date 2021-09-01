@extends(backpack_view('blank'))

@if(backpack_auth()->user()->role === 'Администратор')
    @php
        $widgets['before_content'][] = [
            'type'    => 'div',
            'class'   => 'row',
            'content' => [
                [
                    'type' => 'card',
                    'class' => 'card bg-info text-white',
                    'content' => [
                        'header' => 'Бронирование стола',
                        'body'   => '<b>Запрос POST</b><br>
                        https://'.$_SERVER['HTTP_HOST'].'/add/booking/<br>
                        <b>Объязательные параметры</b><br>
                        <span class="text-dark">user_id</span> ID пользователя<br>
                        <span class="text-dark">organization_id</span> ID организации<br>
                        <span class="text-dark">organization_table_id</span> ID стола<br>
                        <span class="text-dark">start</span> Начало бронирования (21:00:00)<br>
                        <span class="text-dark">end</span> Конец бронирования (21:00:00)<br>
                        <span class="text-dark">date</span> Дата бронирования (Y-m-d)<br>
                        <span class="text-dark">status</span> Статус - CHECKING (На проверке)<br>
                        <b>Не объязательные параметры</b><br>
                        <span class="text-dark">phone</span> Номер телефона (77784443322)<br>
                        <span class="text-dark">comment</span> Комментарии<br>
                        <hr>
                        <button class="btn btn-sm btn-success mt-2" type="button" data-toggle="collapse" data-target="#api-11" aria-expanded="false" aria-controls="api-11">Ответ 200</button>
                        <button class="btn btn-sm btn-danger mt-2" type="button" data-toggle="collapse" data-target="#api-11-400" aria-expanded="false" aria-controls="api-11">Ответ 400</button>
                        <div class="collapse mt-2" id="api-11-400" style="font-size: 10px; line-height: 1;     white-space: pre;">
            {
                "message": "error message"
            }
                        </div>
                        <div class="collapse mt-2" id="api-11" style="font-size: 10px; line-height: 1;     white-space: pre;">
            {
                "data": {
                    "user_id": "2",
                    "organization_id": "1",
                    "organization_table_id": "1",
                    "start": "21:00:00",
                    "end": "23:00:00",
                    "date": "2021-06-03",
                    "phone": null,
                    "comment": null,
                    "status": "На проверке",
                    "updated_at": "2021-05-04T19:52:26.000000Z",
                    "created_at": "2021-05-04T19:52:26.000000Z",
                    "id": 5
                }
            }
                        </div>',
                    ]
                ],
                [
                    'type' => 'card',
                    'class' => 'card bg-info text-white',
                    'content' => [
                        'header' => 'Список бронированных столов пользователя',
                        'body'   => '<b>Запрос GET</b><br>
                        https://'.$_SERVER['HTTP_HOST'].'/api/booking/{id}<br>
                        <b>Долнительные параметры</b><br>
                        <span class="text-dark">{id}</span> ID пользователя<br>
                        <span class="text-dark">?paginate=1</span> в одном запросе 15 результата<br>
                        <hr>
                        <button class="btn btn-sm btn-success mt-2" type="button" data-toggle="collapse" data-target="#api-10" aria-expanded="false" aria-controls="api-10">Ответ 200</button>
                        <div class="collapse mt-2" id="api-10" style="font-size: 10px; line-height: 1;     white-space: pre;">
    {
        "data": [
            {
                "id": 1,
                "organization_id": {
                    "id": 1,
                    "rating": null,
                    "image": null,
                    "title": "Opetit",
                    "title_kz": null,
                    "title_en": null,
                    "description": null,
                    "description_kz": null,
                    "description_en": null,
                    "address": null,
                    "address_kz": null,
                    "address_en": null,
                    "price": null,
                    "tables": null,
                    "monday": {
                        "start": "11:18:00",
                        "end": "11:18:00"
                    },
                    "tuesday": {
                        "start": "11:19:00",
                        "end": "11:19:00"
                    },
                    "wednesday": {
                        "start": "11:19:00",
                        "end": "11:19:00"
                    },
                    "thursday": {
                        "start": "11:19:00",
                        "end": "11:19:00"
                    },
                    "friday": {
                        "start": "11:19:00",
                        "end": "11:19:00"
                    },
                    "saturday": {
                        "start": "11:19:00",
                        "end": "11:19:00"
                    },
                    "sunday": {
                        "start": "11:19:00",
                        "end": "11:19:00"
                    },
                    "status": "Включен",
                    "user_id": {
                        "id": 1,
                        "blocked": "Активный",
                        "name": "Ersa",
                        "avatar": null,
                        "phone": "77784139424",
                        "phone_verified_at": "Подтвержден (5 дней назад)",
                        "email": null,
                        "email_verified_at": "Не подтвержден",
                        "api_token": "qwerty01"
                    },
                    "category_id": {
                        "id": 1,
                        "title": "Ресторан",
                        "title_kz": "Мейрамхана",
                        "title_en": "Restaurant"
                    },
                    "images": [
                        {
                            "id": 1,
                            "image": "uploads/34cb86ef60c03c0a24c11a906580a7ec.jpg"
                        },
                        {
                            "id": 2,
                            "image": "uploads/77f1cf5e6e11b08ccbe9b043260b27cf.jpg"
                        }
                    ]
                },
                "phone": null,
                "comment": null,
                "status": "Включен"
            },
            {
                "id": 2,
                "organization_id": {
                    "id": 1,
                    "rating": null,
                    "image": null,
                    "title": "Opetit",
                    "title_kz": null,
                    "title_en": null,
                    "description": null,
                    "description_kz": null,
                    "description_en": null,
                    "address": null,
                    "address_kz": null,
                    "address_en": null,
                    "price": null,
                    "tables": null,
                    "monday": {
                        "start": "11:18:00",
                        "end": "11:18:00"
                    },
                    "tuesday": {
                        "start": "11:19:00",
                        "end": "11:19:00"
                    },
                    "wednesday": {
                        "start": "11:19:00",
                        "end": "11:19:00"
                    },
                    "thursday": {
                        "start": "11:19:00",
                        "end": "11:19:00"
                    },
                    "friday": {
                        "start": "11:19:00",
                        "end": "11:19:00"
                    },
                    "saturday": {
                        "start": "11:19:00",
                        "end": "11:19:00"
                    },
                    "sunday": {
                        "start": "11:19:00",
                        "end": "11:19:00"
                    },
                    "status": "Включен",
                    "user_id": {
                        "id": 1,
                        "blocked": "Активный",
                        "name": "Ersa",
                        "avatar": null,
                        "phone": "77784139424",
                        "phone_verified_at": "Подтвержден (5 дней назад)",
                        "email": null,
                        "email_verified_at": "Не подтвержден",
                        "api_token": "qwerty01"
                    },
                    "category_id": {
                        "id": 1,
                        "title": "Ресторан",
                        "title_kz": "Мейрамхана",
                        "title_en": "Restaurant"
                    },
                    "images": [
                        {
                            "id": 1,
                            "image": "uploads/34cb86ef60c03c0a24c11a906580a7ec.jpg"
                        },
                        {
                            "id": 2,
                            "image": "uploads/77f1cf5e6e11b08ccbe9b043260b27cf.jpg"
                        }
                    ]
                },
                "phone": "+7778 413 94 24",
                "comment": null,
                "status": "Включен"
            }
        ]
    }
                        </div>',
                    ]
                ],
                [
                    'type' => 'card',
                    'class' => 'card bg-info text-white',
                    'content' => [
                        'header' => 'Список бронированных столов организации',
                        'body'   => '<b>Запрос GET</b><br>
                        https://'.$_SERVER['HTTP_HOST'].'/api/organization/booking/{id}<br>
                        <b>Долнительные параметры</b><br>
                        <span class="text-dark">{id}</span> ID организации<br>
                        <span class="text-dark">?paginate=1</span> в одном запросе 15 результата<br>
                        <hr>
                        <button class="btn btn-sm btn-success mt-2" type="button" data-toggle="collapse" data-target="#api-12" aria-expanded="false" aria-controls="api-12">Ответ 200</button>
                        <div class="collapse mt-2" id="api-12" style="font-size: 10px; line-height: 1;     white-space: pre;">
    {
        data: [
            {
                id: 4,
                organization_id: {
                    id: 1,
                    rating: null,
                    image: null,
                    title: "Opetit",
                    title_kz: null,
                    title_en: null,
                    description: null,
                    description_kz: null,
                    description_en: null,
                    address: null,
                    address_kz: null,
                    address_en: null,
                    price: null,
                    tables: null,
                    monday: {
                        start: "11:18:00",
                        end: "11:18:00",
                    },
                    tuesday: {
                        start: "11:19:00",
                        end: "11:19:00",
                    },
                    wednesday: {
                        start: "11:19:00",
                        end: "11:19:00",
                    },
                    thursday: {
                        start: "11:19:00",
                        end: "11:19:00",
                    },
                    friday: {
                        start: "11:19:00",
                        end: "11:19:00",
                    },
                    saturday: {
                        start: "11:19:00",
                        end: "11:19:00",
                    },
                    sunday: {
                        start: "11:19:00",
                        end: "11:19:00",
                    },
                    status: "Включен",
                    user_id: {
                        id: 1,
                        blocked: "Активный",
                        name: "Ersa",
                        avatar: null,
                        phone: "77784139424",
                        phone_verified_at: "Подтвержден (5 дней назад)",
                        email: null,
                        email_verified_at: "Не подтвержден",
                        api_token: "qwerty01",
                    },
                    category_id: {
                        id: 1,
                        title: "Ресторан",
                        title_kz: "Мейрамхана",
                        title_en: "Restaurant",
                    },
                    images: [
                        {
                            id: 1,
                            image: "uploads/34cb86ef60c03c0a24c11a906580a7ec.jpg",
                        },
                        {
                            id: 2,
                            image: "uploads/77f1cf5e6e11b08ccbe9b043260b27cf.jpg",
                        },
                    ],
                },
                organization_table_id: {
                    id: 1,
                    title: 1,
                    limit: 6,
                    status: "Включен",
                },
                start: "21:00:00",
                end: "23:00:00",
                phone: null,
                comment: null,
                status: "На проверке",
                created_at: "2021-05-04T19:52:26.000000Z",
            },
        ]
    }
                        </div>',
                    ]
                ],
                [
                    'type' => 'card',
                    'class' => 'card bg-info text-white',
                    'content' => [
                        'header' => 'Список заявок на бронирование по ID стола',
                        'body'   => '<b>Запрос GET</b><br>
                        https://'.$_SERVER['HTTP_HOST'].'/api/tables/{id}<br>
                        <b>Долнительные параметры</b><br>
                        <span class="text-dark">{id}</span> ID стола<br>
                        <span class="text-dark">?paginate=1</span> в одном запросе 15 результата<br>
                        <hr>
                        <button class="btn btn-sm btn-success mt-2" type="button" data-toggle="collapse" data-target="#api-14" aria-expanded="false" aria-controls="api-14">Ответ 200</button>
                        <div class="collapse mt-2" id="api-14" style="font-size: 10px; line-height: 1;     white-space: pre;">
    {
        data: [
            {
                id: 4,
                organization_id: {
                    id: 1,
                    rating: null,
                    image: null,
                    title: "Opetit",
                    title_kz: null,
                    title_en: null,
                    description: null,
                    description_kz: null,
                    description_en: null,
                    address: null,
                    address_kz: null,
                    address_en: null,
                    price: null,
                    tables: null,
                    monday: {
                        start: "11:18:00",
                        end: "11:18:00",
                    },
                    tuesday: {
                        start: "11:19:00",
                        end: "11:19:00",
                    },
                    wednesday: {
                        start: "11:19:00",
                        end: "11:19:00",
                    },
                    thursday: {
                        start: "11:19:00",
                        end: "11:19:00",
                    },
                    friday: {
                        start: "11:19:00",
                        end: "11:19:00",
                    },
                    saturday: {
                        start: "11:19:00",
                        end: "11:19:00",
                    },
                    sunday: {
                        start: "11:19:00",
                        end: "11:19:00",
                    },
                    status: "Включен",
                    user_id: {
                        id: 1,
                        blocked: "Активный",
                        name: "Ersa",
                        avatar: null,
                        phone: "77784139424",
                        phone_verified_at: "Подтвержден (5 дней назад)",
                        email: null,
                        email_verified_at: "Не подтвержден",
                        api_token: "qwerty01",
                    },
                    category_id: {
                        id: 1,
                        title: "Ресторан",
                        title_kz: "Мейрамхана",
                        title_en: "Restaurant",
                    },
                    images: [
                        {
                            id: 1,
                            image: "uploads/34cb86ef60c03c0a24c11a906580a7ec.jpg",
                        },
                        {
                            id: 2,
                            image: "uploads/77f1cf5e6e11b08ccbe9b043260b27cf.jpg",
                        },
                    ],
                },
                organization_table_id: {
                    id: 1,
                    title: 1,
                    limit: 6,
                    status: "Включен",
                },
                start: "21:00:00",
                end: "23:00:00",
                phone: null,
                comment: null,
                status: "На проверке",
                created_at: "2021-05-04T19:52:26.000000Z",
            },
        ]
    }
                        </div>',
                    ]
                ],
            ]
        ];

        $widgets['before_content'][] = [
            'type'    => 'div',
            'class'   => 'row',
            'content' => [
                [
                    'type' => 'card',
                    'class' => 'card bg-warning text-white',
                    'content' => [
                        'header' => 'Список категории',
                        'body'   => '<b>Запрос GET</b><br>
                        https://'.$_SERVER['HTTP_HOST'].'/api/categories<br>
                        <hr>
                        <button class="btn btn-sm btn-primary mt-2" type="button" data-toggle="collapse" data-target="#api-8" aria-expanded="false" aria-controls="api-8">Ответ 200</button>
                        <div class="collapse mt-2" id="api-8" style="font-size: 10px; line-height: 1;">
                        <div>{</div>
                        <div class="ml-1">"data": [</div>
                        <div class="ml-2">{</div>
                        <div class="ml-3">"id": <b>1</b>,</div>
                        <div class="ml-3">"title": <b>"Ресторан"</b>,</div>
                        <div class="ml-3">"title_kz": <b>"Мейрамхана"</b>,</div>
                        <div class="ml-3">"title_en": <b>"Restaurant"</b>,</div>
                        <div class="ml-2">}</div>
                        <div class="ml-2">{</div>
                        <div class="ml-3">"id": <b>2</b>,</div>
                        <div class="ml-3">"title": <b>"Кафе"</b>,</div>
                        <div class="ml-3">"title_kz": <b>"Кафе"</b>,</div>
                        <div class="ml-3">"title_en": <b>"Cafe"</b>,</div>
                        <div class="ml-2">}</div>
                        <div class="ml-2">{</div>
                        <div class="ml-3">"id": <b>3</b>,</div>
                        <div class="ml-3">"title": <b>"Бар"</b>,</div>
                        <div class="ml-3">"title_kz": <b>"Бар"</b>,</div>
                        <div class="ml-3">"title_en": <b>"Bar"</b>,</div>
                        <div class="ml-2">}</div>
                        <div class="ml-1">]</div>
                        <div>}</div>
                        </div>',
                    ]
                ],
                [
                    'type' => 'card',
                    'class' => 'card bg-warning text-white',
                    'content' => [
                        'header' => 'Список стран и городов',
                        'body'   => '<b>Запрос GET</b><br>
                        https://'.$_SERVER['HTTP_HOST'].'/api/countries<br>
                        <hr>
                        <button class="btn btn-sm btn-primary mt-2" type="button" data-toggle="collapse" data-target="#api-9" aria-expanded="false" aria-controls="api-9">Ответ 200</button>
                        <div class="collapse mt-2" id="api-9" style="font-size: 10px; line-height: 1;">
                        <div>{</div>
                        <div class="ml-1">"data": [</div>
                        <div class="ml-2">{</div>
                        <div class="ml-3">"id": <b>1</b>,</div>
                        <div class="ml-3">"title": <b>"Казахстан"</b>,</div>
                        <div class="ml-3">"title_kz": <b>"Қазақстан"</b>,</div>
                        <div class="ml-3">"title_en": <b>"title_en"</b>,</div>
                        <div class="ml-3">"city_id": [</div>
                        <div class="ml-4">{</div>
                        <div class="ml-5">"id": <b>1</b>,</div>
                        <div class="ml-5">"title": <b>"Алматы"</b>,</div>
                        <div class="ml-5">"title_kz": <b>"Алматы"</b>,</div>
                        <div class="ml-5">"title_en": <b>"Almaty"</b>,</div>
                        <div class="ml-4">}</div>
                        <div class="ml-3">]</div>
                        <div class="ml-2">}</div>
                        <div class="ml-1">]</div>
                        <div>}</div>
                        </div>',
                    ]
                ],
                [
                    'type' => 'card',
                    'class' => 'card bg-warning text-white',
                    'content' => [
                        'header' => 'Список помещении и столов организации',
                        'body'   => '<b>Запрос GET</b><br>
                        https://'.$_SERVER['HTTP_HOST'].'/api/organization/section/{id}<br>
                        <b>Долнительные параметры</b><br>
                        <span class="text-dark">{id}</span> ID организации<br>
                        <hr>
                        <button class="btn btn-sm btn-primary mt-2" type="button" data-toggle="collapse" data-target="#api-25" aria-expanded="false" aria-controls="api-25">Ответ 200</button>
                        <div class="collapse mt-2" id="api-25" style="font-size: 10px; line-height: 1; white-space: pre;">
                        {
    data: [
    {
    id: 1,
    name: "Зал",
    limit: 0,
    status: "Включен",
    organization_tables: [
    {
    id: 1,
    organization_id: 1,
    organization_table_id: 1,
    limit: 2,
    status: "ENABLED",
    },
    {
    id: 2,
    organization_id: 1,
    organization_table_id: 1,
    limit: 4,
    status: "ENABLED",
    },
    ],
    },
    {
    id: 2,
    name: "Бар",
    limit: 0,
    status: "Включен",
    organization_tables: [ ],
    },
    {
    id: 3,
    name: "Кухня",
    limit: 0,
    status: "Включен",
    organization_tables: [ ],
    },
    ]
    }
                        </div>',
                    ]
                ],
            ]
        ];

        $widgets['before_content'][] = [
            'type'    => 'div',
            'class'   => 'row',
            'content' => [
                [
                    'type' => 'card',
                    'class' => 'card bg-success text-white',
                    'content' => [
                        'header' => 'Авторизация пользователя по номеру телефона и пароля',
                        'body'   => '<b>Запрос GET</b><br>
                        https://'.$_SERVER['HTTP_HOST'].'/api/login/{phone}/{password}<br>
                        <b>Параметры</b><br>
                        <span class="text-dark">{phone}</span> номер телефона<br>
                        <span class="text-dark">{password}</span> пароль<br>
                        <hr>
                        <button class="btn btn-sm btn-primary mt-2" type="button" data-toggle="collapse" data-target="#api-7" aria-expanded="false" aria-controls="api-7">Ответ 200</button>
                        <button class="btn btn-sm btn-danger mt-2" type="button" data-toggle="collapse" data-target="#api-7-401" aria-expanded="false" aria-controls="api-5-400">Ответ 400</button>
                        <div class="collapse mt-2" id="api-7-400" style="font-size: 10px; line-height: 1;">
                        <div>{</div>
                        <div class="ml-1">message: <b>incorrect phone or password</b>,</div>
                        <div>}</div>
                        </div>
                        <div class="collapse mt-2" id="api-7" style="font-size: 10px; line-height: 1;">
                        <div>{</div>
                        <div class="ml-1">data: {</div>
                        <div class="ml-2">id: <b>44</b>,</div>
                        <div class="ml-2">blocked: <b>""</b>,</div>
                        <div class="ml-2">name: <b>"User"</b>,</div>
                        <div class="ml-2">avatar: null,</div>
                        <div class="ml-2">phone: <b>"77784443322"</b>,</div>
                        <div class="ml-2">phone_verified_at: <b>"Не подтвержден"</b>,</div>
                        <div class="ml-2">email: null,</div>
                        <div class="ml-2">email_verified_at: <b>"Не подтвержден"</b>,</div>
                        <div class="ml-2">api_token: <b>"ZhADV5ZereEOsVPHyJHEqVAtg8MIRgkSerzgPtBEzgb8RiOF7XSJnqX0adMO"</b>,</div>
                        <div class="ml-1">}</div>
                        <div>}</div>
                        </div>',
                    ]
                ],
                [
                    'type' => 'card',
                    'class' => 'card bg-success text-white',
                    'content' => [
                        'header' => 'Получить данные пользователя по токену',
                        'body'   => '<b>Запрос GET</b><br>
                        https://'.$_SERVER['HTTP_HOST'].'/api/token/{token}<br>
                        <b>Параметры</b><br>
                        <span class="text-dark">{token}</span> api_token<br>
                        <hr>
                        <button class="btn btn-sm btn-primary mt-2" type="button" data-toggle="collapse" data-target="#api-6" aria-expanded="false" aria-controls="api-6">Ответ 200</button>
                        <button class="btn btn-sm btn-danger mt-2" type="button" data-toggle="collapse" data-target="#api-6-400" aria-expanded="false" aria-controls="api-5-400">Ответ 400</button>
                        <div class="collapse mt-2" id="api-6-400" style="font-size: 10px; line-height: 1;">
                        <div>{</div>
                        <div class="ml-1">message: <b>token expired</b>,</div>
                        <div>}</div>
                        </div>
                        <div class="collapse mt-2" id="api-6" style="font-size: 10px; line-height: 1;">
                        <div>{</div>
                        <div class="ml-1">data: {</div>
                        <div class="ml-2">id: <b>44</b>,</div>
                        <div class="ml-2">blocked: <b>""</b>,</div>
                        <div class="ml-2">name: <b>"User"</b>,</div>
                        <div class="ml-2">avatar: null,</div>
                        <div class="ml-2">phone: <b>"77784443322"</b>,</div>
                        <div class="ml-2">phone_verified_at: <b>"Не подтвержден"</b>,</div>
                        <div class="ml-2">email: null,</div>
                        <div class="ml-2">email_verified_at: <b>"Не подтвержден"</b>,</div>
                        <div class="ml-2">api_token: <b>"ZhADV5ZereEOsVPHyJHEqVAtg8MIRgkSerzgPtBEzgb8RiOF7XSJnqX0adMO"</b>,</div>
                        <div class="ml-1">}</div>
                        <div>}</div>
                        </div>',
                    ]
                ],
                [
                    'type' => 'card',
                    'class' => 'card bg-success text-white',
                    'content' => [
                        'header' => 'Регистрация пользователя',
                        'body'   => '<b>Запрос GET</b><br>
                        https://'.$_SERVER['HTTP_HOST'].'/api/register/<br>
                        <b>Параметры для регистрации</b><br>
                        <span class="text-dark">?phone=77784443322</span> Номер телефона<br>
                        <span class="text-dark">?name=User</span> Имя пользователя<br>
                        <span class="text-dark">?password=qwerty00</span> Пароль<br>
                        <hr>
                        <button class="btn btn-sm btn-primary mt-2" type="button" data-toggle="collapse" data-target="#api-5" aria-expanded="false" aria-controls="api-5">Ответ 200</button>
                        <button class="btn btn-sm btn-danger mt-2" type="button" data-toggle="collapse" data-target="#api-5-400" aria-expanded="false" aria-controls="api-5-400">Ответ 400</button>
                        <div class="collapse mt-2" id="api-5-400" style="font-size: 10px; line-height: 1;">
                        <div>{</div>
                        <div class="ml-1">message: <b>error message</b>,</div>
                        <div>}</div>
                        </div>
                        <div class="collapse mt-2" id="api-5" style="font-size: 10px; line-height: 1;">
                        <div>{</div>
                        <div class="ml-1">data: {</div>
                        <div class="ml-2">id: <b>44</b>,</div>
                        <div class="ml-2">blocked: <b>""</b>,</div>
                        <div class="ml-2">name: <b>"User"</b>,</div>
                        <div class="ml-2">avatar: null,</div>
                        <div class="ml-2">phone: <b>"77784443322"</b>,</div>
                        <div class="ml-2">phone_verified_at: <b>"Не подтвержден"</b>,</div>
                        <div class="ml-2">email: null,</div>
                        <div class="ml-2">email_verified_at: <b>"Не подтвержден"</b>,</div>
                        <div class="ml-2">api_token: <b>"ZhADV5ZereEOsVPHyJHEqVAtg8MIRgkSerzgPtBEzgb8RiOF7XSJnqX0adMO"</b>,</div>
                        <div class="ml-1">}</div>
                        <div>}</div>
                        </div>',
                    ]
                ],
                [
                    'type' => 'card',
                    'class' => 'card bg-success text-white',
                    'content' => [
                        'header' => 'Пользователь по ID',
                        'body'   => '<b>Запрос GET</b><br>
                        https://'.$_SERVER['HTTP_HOST'].'/api/user/{id}<br>
                        <b>Долнительные параметры</b><br>
                        <span class="text-dark">{id}</span> ID пользователя<br>
                        <hr>
                        <button class="btn btn-sm btn-primary mt-2" type="button" data-toggle="collapse" data-target="#api-4" aria-expanded="false" aria-controls="api-4">Ответ 200</button>
                        <button class="btn btn-sm btn-danger mt-2" type="button" data-toggle="collapse" data-target="#api-4-404" aria-expanded="false" aria-controls="api-4-404">Ответ 404</button>
                        <div class="collapse mt-2" id="api-4-404" style="font-size: 10px; line-height: 1;">
                            <div>{</div>
                            <div class="ml-1">message: "Пользователь не найден"</div>
                            <div>}</div>
                        </div>
                        <div class="collapse mt-2" id="api-4" style="font-size: 10px; line-height: 1;">
                            <div>{</div>
                            <div class="ml-1">data: {</div>
                            <div class="ml-2">id: <b>1</b>,</div>
                            <div class="ml-2">blocked: <b>"Активный"</b>,</div>
                            <div class="ml-2">name: <b>"Name Surname"</b>,</div>
                            <div class="ml-2">avatar: null,</div>
                            <div class="ml-2">phone: <b>"+77784139424"</b>,</div>
                            <div class="ml-2">phone_verified_at: <b>"Подтвержден (4 дня назад)"</b>,</div>
                            <div class="ml-2">email: null,</b>,</div>
                            <div class="ml-2">email_verified_at: <b>"Не подтвержден"</b>,</div>
                            <div class="ml-1">}</div>
                            <div>}</div>
                        </div>',
                    ]
                ],
                [
                    'type' => 'card',
                    'class' => 'card bg-success text-white',
                    'content' => [
                        'header' => 'Подтверждение телефон номера SMS code',
                        'body'   => '<b>Запрос GET</b><br>
                        https://'.$_SERVER['HTTP_HOST'].'/api/sms/{phone}/{code}<br>
                        <b>Параметры</b><br>
                        <span class="text-dark">{phone}</span> Номер телефона (77776665544)<br>
                        <span class="text-dark">{code}</span> Код отправленный на номер (159963)<br>
                        <hr>
                        <button class="btn btn-sm btn-primary mt-2" type="button" data-toggle="collapse" data-target="#api-16" aria-expanded="false" aria-controls="api-16">Ответ 200</button>
                        <button class="btn btn-sm btn-danger mt-2" type="button" data-toggle="collapse" data-target="#api-16-400" aria-expanded="false" aria-controls="api-16-400">Ответ 400</button>
                        <div class="collapse mt-2" id="api-16-400" style="font-size: 10px; line-height: 1;">
    {
        "message": "incorrect code"
    }
                        </div>
                        <div class="collapse mt-2" id="api-16" style="font-size: 10px; line-height: 1; white-space: pre;">
    {
        "data": {
            "id": 1,
            "blocked": "Активный",
            "name": "Ersa",
            "avatar": null,
            "phone": "77784139424",
            "phone_verified_at": "Подтвержден (1 секунду назад)",
            "email": null,
            "email_verified_at": "Не подтвержден",
            "api_token": "qwerty01"
        }
    }
                        </div>',
                    ]
                ],
                [
                    'type' => 'card',
                    'class' => 'card bg-success text-white',
                    'content' => [
                        'header' => 'Переотправка SMS для подтверждения номера',
                        'body'   => '<b>Запрос GET</b><br>
                        https://'.$_SERVER['HTTP_HOST'].'/api/sms_verify/{phone}<br>
                        <b>Параметры</b><br>
                        <span class="text-dark">{phone}</span> Номер телефона (77776665544)<br>
                        <hr>
                        <button class="btn btn-sm btn-primary mt-2" type="button" data-toggle="collapse" data-target="#api-16a" aria-expanded="false" aria-controls="api-16a">Ответ 200</button>
                        <button class="btn btn-sm btn-danger mt-2" type="button" data-toggle="collapse" data-target="#api-16a-400" aria-expanded="false" aria-controls="api-16a-400">Ответ 400</button>
                        <div class="collapse mt-2" id="api-16a-400" style="font-size: 10px; line-height: 1;">
                            {
                                "message": "Phone doesn\'t exist"
                            }
                        </div>
                        <div class="collapse mt-2" id="api-16a" style="font-size: 10px; line-height: 1; white-space: pre;">
                            {
                                "data": {
                                    "id": 1,
                                    "blocked": "Активный",
                                    "name": "Ersa",
                                    "avatar": null,
                                    "phone": "77784139424",
                                    "phone_verified_at": "Не подтвержден",
                                    "email": null,
                                    "email_verified_at": "Не подтвержден",
                                    "api_token": "qwerty01"
                                }
                            }
                        </div>',
                    ]
                ]
            ]
        ];

        $widgets['before_content'][] = [
            'type'    => 'div',
            'class'   => 'row',
            'content' => [ // widgets
                ['type' =>  'card', 'class'   => 'card bg-primary text-white', 'content'   =>  [
                'header' => 'Список всех организации', // optional
                'body'   => '<b>Запрос GET</b><br>
                https://'.$_SERVER['HTTP_HOST'].'/api/organizations<br>
                <b>Долнительные параметры</b><br>
                <span class="text-dark">?paginate=1</span> в одном запросе 15 результата<br>
                <hr>
                <button class="btn btn-sm btn-success mt-2" type="button" data-toggle="collapse" data-target="#api-1" aria-expanded="false" aria-controls="api-1">Ответ 200</button>
                <div class="collapse mt-2" id="api-1" style="font-size: 10px; line-height: 1;">
                    <div>{</div>
                    <div class="ml-1">data: [</div>
                    <div class="ml-2">{</div>
                    <div class="ml-3">id: <b>1</b>,</div>
                    <div class="ml-3">rating: null,</div>
                    <div class="ml-3">image: null,</div>
                    <div class="ml-3">title: <b>"Opetit"</b>,</div>
                    <div class="ml-3">title_kz: null,</div>
                    <div class="ml-3">title_en: null,</div>
                    <div class="ml-3">description: null,</div>
                    <div class="ml-3">description_kz: null,</div>
                    <div class="ml-3">description_en: null,</div>
                    <div class="ml-3">address: null,</div>
                    <div class="ml-3">address_kz: null,</div>
                    <div class="ml-3">address_en: null,</div>
                    <div class="ml-3">price: null,</div>
                    <div class="ml-3">tables: null,</div>
                    <div class="ml-3">monday: {</div>
                    <div class="ml-4">start: <b>"11:18:00"</b>,</div>
                    <div class="ml-4">end: <b>"11:18:00"</b>,</div>
                    <div class="ml-3">},</div>
                    <div class="ml-3">tuesday: {</div>
                    <div class="ml-4">start: <b>"11:18:00"</b>,</div>
                    <div class="ml-4">end: <b>"11:18:00"</b>,</div>
                    <div class="ml-3">},</div>
                    <div class="ml-3">wednesday: {</div>
                    <div class="ml-4">start: <b>"11:18:00"</b>,</div>
                    <div class="ml-4">end: <b>"11:18:00"</b>,</div>
                    <div class="ml-3">},</div>
                    <div class="ml-3">thursday: {</div>
                    <div class="ml-4">start: <b>"11:18:00"</b>,</div>
                    <div class="ml-4">end: <b>"11:18:00"</b>,</div>
                    <div class="ml-3">},</div>
                    <div class="ml-3">friday: {</div>
                    <div class="ml-4">start: <b>"11:18:00"</b>,</div>
                    <div class="ml-4">end: <b>"11:18:00"</b>,</div>
                    <div class="ml-3">},</div>
                    <div class="ml-3">saturday: {</div>
                    <div class="ml-4">start: <b>"11:18:00"</b>,</div>
                    <div class="ml-4">end: <b>"11:18:00"</b>,</div>
                    <div class="ml-3">},</div>
                    <div class="ml-3">sunday: {</div>
                    <div class="ml-4">start: <b>"11:18:00"</b>,</div>
                    <div class="ml-4">end: <b>"11:18:00"</b>,</div>
                    <div class="ml-3">},</div>
                    <div class="ml-3">status: <b>"Включен"</b>,</div>
                    <div class="ml-3">user_id: {</div>
                    <div class="ml-4">id: <b>1</b>,</div>
                    <div class="ml-4">blocked: <b>"Активный"</b>,</div>
                    <div class="ml-4">name: <b>"Ersa"</b>,</div>
                    <div class="ml-4">avatar: null,</div>
                    <div class="ml-4">phone: <b>"77784443322"</b>,</div>
                    <div class="ml-4">phone_verified_at: <b>"Подтвержден (4 дня назад)"</b>,</div>
                    <div class="ml-4">email: null,</div>
                    <div class="ml-4">email_verified_at: <b>"Не подтвержден"</b>,</div>
                    <div class="ml-3">},</div>
                    <div class="ml-3">category_id: {</div>
                    <div class="ml-4">id: <b>1</b>,</div>
                    <div class="ml-4">title: <b>"Ресторан"</b>,</div>
                    <div class="ml-4">title_kz: <b>"Мейрамхана"</b>,</div>
                    <div class="ml-4">title_en: <b>"Restaurant"</b>,</b>,</div>
                    <div class="ml-3">},</div>
                    <div class="ml-3">images: [</div>
                    <div class="ml-4">{</div>
                    <div class="ml-5">id: <b>1</b>,</div>
                    <div class="ml-5">image: <b>"uploads/34cb86ef60c03c0a24c11a906580a7ec.jpg"</b>,</div>
                    <div class="ml-4">},</div>

                    <div class="ml-5">id: <b>2</b>,</div>
                    <div class="ml-5">image: <b>"uploads/77f1cf5e6e11b08ccbe9b043260b27cf.jpg"</b>,</div>
                    <div class="ml-4">},</div>
                    <div class="ml-3">],</div>
                    <div class="ml-2">},</div>
                    <div class="ml-1">]</div>
                    <div>}</div>
                </div>',
            ]
            ],
                ['type' =>  'card', 'class'   => 'card bg-primary text-white', 'content'   =>  [
                    'header' => 'Организация по ID', // optional
                    'body'   => '<b>Запрос GET</b><br>
                    https://'.$_SERVER['HTTP_HOST'].'/api/organization/1<br>
                    <hr>
                    <button class="btn btn-sm btn-success mt-2" type="button" data-toggle="collapse" data-target="#api-2" aria-expanded="false" aria-controls="api-2">Ответ 200</button>
                    <button class="btn btn-sm btn-danger mt-2" type="button" data-toggle="collapse" data-target="#api-2-404" aria-expanded="false" aria-controls="api-2-404">Ответ 404</button>
                    <div class="collapse mt-2" id="api-2-404" style="font-size: 10px; line-height: 1;">
                    <div>{</div>
                    <div class="ml-1">message: "Организация не найдено"</div>
                    <div>}</div>
                    </div>
                    <div class="collapse mt-2" id="api-2" style="font-size: 10px; line-height: 1;">
    <div>{</div>
                    <div class="ml-1">data: {</div>
                    <div class="ml-3">id: <b>1</b>,</div>
                    <div class="ml-3">rating: null,</div>
                    <div class="ml-3">image: null,</div>
                    <div class="ml-3">title: <b>"Opetit"</b>,</div>
                    <div class="ml-3">title_kz: null,</div>
                    <div class="ml-3">title_en: null,</div>
                    <div class="ml-3">description: null,</div>
                    <div class="ml-3">description_kz: null,</div>
                    <div class="ml-3">description_en: null,</div>
                    <div class="ml-3">address: null,</div>
                    <div class="ml-3">address_kz: null,</div>
                    <div class="ml-3">address_en: null,</div>
                    <div class="ml-3">price: null,</div>
                    <div class="ml-3">tables: null,</div>
                    <div class="ml-3">monday: {</div>
                    <div class="ml-4">start: <b>"11:18:00"</b>,</div>
                    <div class="ml-4">end: <b>"11:18:00"</b>,</div>
                    <div class="ml-3">},</div>
                    <div class="ml-3">tuesday: {</div>
                    <div class="ml-4">start: <b>"11:18:00"</b>,</div>
                    <div class="ml-4">end: <b>"11:18:00"</b>,</div>
                    <div class="ml-3">},</div>
                    <div class="ml-3">wednesday: {</div>
                    <div class="ml-4">start: <b>"11:18:00"</b>,</div>
                    <div class="ml-4">end: <b>"11:18:00"</b>,</div>
                    <div class="ml-3">},</div>
                    <div class="ml-3">thursday: {</div>
                    <div class="ml-4">start: <b>"11:18:00"</b>,</div>
                    <div class="ml-4">end: <b>"11:18:00"</b>,</div>
                    <div class="ml-3">},</div>
                    <div class="ml-3">friday: {</div>
                    <div class="ml-4">start: <b>"11:18:00"</b>,</div>
                    <div class="ml-4">end: <b>"11:18:00"</b>,</div>
                    <div class="ml-3">},</div>
                    <div class="ml-3">saturday: {</div>
                    <div class="ml-4">start: <b>"11:18:00"</b>,</div>
                    <div class="ml-4">end: <b>"11:18:00"</b>,</div>
                    <div class="ml-3">},</div>
                    <div class="ml-3">sunday: {</div>
                    <div class="ml-4">start: <b>"11:18:00"</b>,</div>
                    <div class="ml-4">end: <b>"11:18:00"</b>,</div>
                    <div class="ml-3">},</div>
                    <div class="ml-3">status: <b>"Включен"</b>,</div>
                    <div class="ml-3">user_id: {</div>
                    <div class="ml-4">id: <b>1</b>,</div>
                    <div class="ml-4">blocked: <b>"Активный"</b>,</div>
                    <div class="ml-4">name: <b>"Ersa"</b>,</div>
                    <div class="ml-4">avatar: null,</div>
                    <div class="ml-4">phone: <b>"77784443322"</b>,</div>
                    <div class="ml-4">phone_verified_at: <b>"Подтвержден (4 дня назад)"</b>,</div>
                    <div class="ml-4">email: null,</div>
                    <div class="ml-4">email_verified_at: <b>"Не подтвержден"</b>,</div>
                    <div class="ml-3">},</div>
                    <div class="ml-3">category_id: {</div>
                    <div class="ml-4">id: <b>1</b>,</div>
                    <div class="ml-4">title: <b>"Ресторан"</b>,</div>
                    <div class="ml-4">title_kz: <b>"Мейрамхана"</b>,</div>
                    <div class="ml-4">title_en: <b>"Restaurant"</b>,</b>,</div>
                    <div class="ml-3">},</div>
                    <div class="ml-3">images: [</div>
                    <div class="ml-4">{</div>
                    <div class="ml-5">id: <b>1</b>,</div>
                    <div class="ml-5">image: <b>"uploads/34cb86ef60c03c0a24c11a906580a7ec.jpg"</b>,</div>
                    <div class="ml-4">},</div>

                    <div class="ml-5">id: <b>2</b>,</div>
                    <div class="ml-5">image: <b>"uploads/77f1cf5e6e11b08ccbe9b043260b27cf.jpg"</b>,</div>
                    <div class="ml-4">},</div>
                    <div class="ml-3">],</div>
                    <div class="ml-2">},</div>
                    <div>}</div>
                    </div>',
                ]],
                ['type' =>  'card', 'class'   => 'card bg-primary text-white', 'content'   =>  [
                    'header' => 'Поиск организации по названию', // optional
                    'body'   => '<b>Запрос GET</b><br>
                    https://'.$_SERVER['HTTP_HOST'].'/api/organizations/{search}<br>
                    <b>Долнительные параметры</b><br>
                    <span class="text-dark">{search}</span> название заведения<br>
                    <span class="text-dark">?paginate=1</span> в одном запросе 15 результата<br>
                    <hr>
                    <button class="btn btn-sm btn-success mt-2" type="button" data-toggle="collapse" data-target="#api-3" aria-expanded="false" aria-controls="api-3">Ответ 200</button>
                    <div class="collapse mt-2" id="api-3" style="font-size: 10px; line-height: 1;">
                    <div>{</div>
                    <div class="ml-1">data: {</div>
                    <div class="ml-3">id: <b>1</b>,</div>
                    <div class="ml-3">rating: null,</div>
                    <div class="ml-3">image: null,</div>
                    <div class="ml-3">title: <b>"Opetit"</b>,</div>
                    <div class="ml-3">title_kz: null,</div>
                    <div class="ml-3">title_en: null,</div>
                    <div class="ml-3">description: null,</div>
                    <div class="ml-3">description_kz: null,</div>
                    <div class="ml-3">description_en: null,</div>
                    <div class="ml-3">address: null,</div>
                    <div class="ml-3">address_kz: null,</div>
                    <div class="ml-3">address_en: null,</div>
                    <div class="ml-3">price: null,</div>
                    <div class="ml-3">tables: null,</div>
                    <div class="ml-3">monday: {</div>
                    <div class="ml-4">start: <b>"11:18:00"</b>,</div>
                    <div class="ml-4">end: <b>"11:18:00"</b>,</div>
                    <div class="ml-3">},</div>
                    <div class="ml-3">tuesday: {</div>
                    <div class="ml-4">start: <b>"11:18:00"</b>,</div>
                    <div class="ml-4">end: <b>"11:18:00"</b>,</div>
                    <div class="ml-3">},</div>
                    <div class="ml-3">wednesday: {</div>
                    <div class="ml-4">start: <b>"11:18:00"</b>,</div>
                    <div class="ml-4">end: <b>"11:18:00"</b>,</div>
                    <div class="ml-3">},</div>
                    <div class="ml-3">thursday: {</div>
                    <div class="ml-4">start: <b>"11:18:00"</b>,</div>
                    <div class="ml-4">end: <b>"11:18:00"</b>,</div>
                    <div class="ml-3">},</div>
                    <div class="ml-3">friday: {</div>
                    <div class="ml-4">start: <b>"11:18:00"</b>,</div>
                    <div class="ml-4">end: <b>"11:18:00"</b>,</div>
                    <div class="ml-3">},</div>
                    <div class="ml-3">saturday: {</div>
                    <div class="ml-4">start: <b>"11:18:00"</b>,</div>
                    <div class="ml-4">end: <b>"11:18:00"</b>,</div>
                    <div class="ml-3">},</div>
                    <div class="ml-3">sunday: {</div>
                    <div class="ml-4">start: <b>"11:18:00"</b>,</div>
                    <div class="ml-4">end: <b>"11:18:00"</b>,</div>
                    <div class="ml-3">},</div>
                    <div class="ml-3">status: <b>"Включен"</b>,</div>
                    <div class="ml-3">user_id: {</div>
                    <div class="ml-4">id: <b>1</b>,</div>
                    <div class="ml-4">blocked: <b>"Активный"</b>,</div>
                    <div class="ml-4">name: <b>"Ersa"</b>,</div>
                    <div class="ml-4">avatar: null,</div>
                    <div class="ml-4">phone: <b>"77784443322"</b>,</div>
                    <div class="ml-4">phone_verified_at: <b>"Подтвержден (4 дня назад)"</b>,</div>
                    <div class="ml-4">email: null,</div>
                    <div class="ml-4">email_verified_at: <b>"Не подтвержден"</b>,</div>
                    <div class="ml-3">},</div>
                    <div class="ml-3">category_id: {</div>
                    <div class="ml-4">id: <b>1</b>,</div>
                    <div class="ml-4">title: <b>"Ресторан"</b>,</div>
                    <div class="ml-4">title_kz: <b>"Мейрамхана"</b>,</div>
                    <div class="ml-4">title_en: <b>"Restaurant"</b>,</b>,</div>
                    <div class="ml-3">},</div>
                    <div class="ml-3">images: [</div>
                    <div class="ml-4">{</div>
                    <div class="ml-5">id: <b>1</b>,</div>
                    <div class="ml-5">image: <b>"uploads/34cb86ef60c03c0a24c11a906580a7ec.jpg"</b>,</div>
                    <div class="ml-4">},</div>
                    <div class="ml-4">{</div>
                    <div class="ml-5">id: <b>2</b>,</div>
                    <div class="ml-5">image: <b>"uploads/77f1cf5e6e11b08ccbe9b043260b27cf.jpg"</b>,</div>
                    <div class="ml-4">},</div>
                    <div class="ml-3">],</div>
                    <div class="ml-2">},</div>
                    <div>}</div>
                    </div>',
                ]],
                ['type' =>  'card', 'class'   => 'card bg-primary text-white', 'content'   =>  [
                    'header' => 'Поиск организации по городу и названию', // optional
                    'body'   => '<b>Запрос GET</b><br>
                    https://'.$_SERVER['HTTP_HOST'].'/api/city/organizations/{id}<br>
                    <b>Параметры</b><br>
                    <span class="text-dark">{id}</span> ID города<br>
                    <span class="text-dark">?paginate=1</span> в одном запросе 15 результата<br>
                    <b>Не обязатальные параметры</b><br>
                    <span class="text-dark">?search=Opetit</span> название заведении<br>
                    <hr>
                    <button class="btn btn-sm btn-success mt-2" type="button" data-toggle="collapse" data-target="#api-17" aria-expanded="false" aria-controls="api-17">Ответ 200</button>
                    <div class="collapse mt-2" id="api-17" style="font-size: 10px; line-height: 1; white-space: pre;">
    {
        "data": [
            {
                "id": 1,
                "rating": null,
                "image": null,
                "title": "Opetit",
                "title_kz": null,
                "title_en": null,
                "description": null,
                "description_kz": null,
                "description_en": null,
                "address": null,
                "address_kz": null,
                "address_en": null,
                "price": null,
                "tables": null,
                "monday": {
                    "start": "11:18:00",
                    "end": "11:18:00"
                },
                "tuesday": {
                    "start": "11:19:00",
                    "end": "11:19:00"
                },
                "wednesday": {
                    "start": "11:19:00",
                    "end": "11:19:00"
                },
                "thursday": {
                    "start": "11:19:00",
                    "end": "11:19:00"
                },
                "friday": {
                    "start": "11:19:00",
                    "end": "11:19:00"
                },
                "saturday": {
                    "start": "11:19:00",
                    "end": "11:19:00"
                },
                "sunday": {
                    "start": "11:19:00",
                    "end": "11:19:00"
                },
                "status": "Включен",
                "user_id": {
                    "id": 1,
                    "blocked": "Активный",
                    "name": "Ersa",
                    "avatar": null,
                    "phone": "77784139424",
                    "phone_verified_at": "Подтвержден (22 часа назад)",
                    "email": null,
                    "email_verified_at": "Не подтвержден",
                    "api_token": "qwerty01"
                },
                "category_id": {
                    "id": 1,
                    "title": "Ресторан",
                    "title_kz": "Мейрамхана",
                    "title_en": "Restaurant"
                },
                "images": [
                    {
                        "id": 1,
                        "image": "uploads/34cb86ef60c03c0a24c11a906580a7ec.jpg"
                    },
                    {
                        "id": 2,
                        "image": "uploads/77f1cf5e6e11b08ccbe9b043260b27cf.jpg"
                    }
                ]
            }
        ]
    }
                    </div>',
                ]],
                ['type' =>  'card', 'class'   => 'card bg-primary text-white', 'content'   =>  [
                    'header' => 'Поиск организации по категории', // optional
                    'body'   => '<b>Запрос GET</b><br>
                    https://'.$_SERVER['HTTP_HOST'].'/api/category/organizations/{id}<br>
                    <b>Параметры</b><br>
                    <span class="text-dark">{id}</span> ID категории<br>
                    <span class="text-dark">?paginate=1</span> в одном запросе 15 результата<br>
                    <hr>
                    <button class="btn btn-sm btn-success mt-2" type="button" data-toggle="collapse" data-target="#api-17" aria-expanded="false" aria-controls="api-17">Ответ 200</button>
                    <div class="collapse mt-2" id="api-17" style="font-size: 10px; line-height: 1; white-space: pre;">
    {
        "data": [
            {
                "id": 1,
                "rating": null,
                "image": null,
                "title": "Opetit",
                "title_kz": null,
                "title_en": null,
                "description": null,
                "description_kz": null,
                "description_en": null,
                "address": null,
                "address_kz": null,
                "address_en": null,
                "price": null,
                "tables": null,
                "monday": {
                    "start": "11:18:00",
                    "end": "11:18:00"
                },
                "tuesday": {
                    "start": "11:19:00",
                    "end": "11:19:00"
                },
                "wednesday": {
                    "start": "11:19:00",
                    "end": "11:19:00"
                },
                "thursday": {
                    "start": "11:19:00",
                    "end": "11:19:00"
                },
                "friday": {
                    "start": "11:19:00",
                    "end": "11:19:00"
                },
                "saturday": {
                    "start": "11:19:00",
                    "end": "11:19:00"
                },
                "sunday": {
                    "start": "11:19:00",
                    "end": "11:19:00"
                },
                "status": "Включен",
                "user_id": {
                    "id": 1,
                    "blocked": "Активный",
                    "name": "Ersa",
                    "avatar": null,
                    "phone": "77784139424",
                    "phone_verified_at": "Подтвержден (22 часа назад)",
                    "email": null,
                    "email_verified_at": "Не подтвержден",
                    "api_token": "qwerty01"
                },
                "category_id": {
                    "id": 1,
                    "title": "Ресторан",
                    "title_kz": "Мейрамхана",
                    "title_en": "Restaurant"
                },
                "images": [
                    {
                        "id": 1,
                        "image": "uploads/34cb86ef60c03c0a24c11a906580a7ec.jpg"
                    },
                    {
                        "id": 2,
                        "image": "uploads/77f1cf5e6e11b08ccbe9b043260b27cf.jpg"
                    }
                ]
            }
        ]
    }
                    </div>',
                ]],
            ]
        ];

    $widgets['before_content'][] = [
            'type'    => 'div',
            'class'   => 'row',
            'content' => [ // widgets
                ['type' =>  'card', 'class'   => 'card bg-warning text-white', 'content'   =>  [
                'header' => 'Оставить отзыв', // optional
                'body'   => '<b>Запрос POST</b><br>
                https://'.$_SERVER['HTTP_HOST'].'/api/review/create<br>
                <b>POST параметры</b><br>
                <span class="text-dark">organization_id</span> ID организации<br>
                <span class="text-dark">user_id</span> ID пользователя<br>
                <span class="text-dark">rating</span> рейтинг (1-5)<br>
                <span class="text-dark">comment</span> Комментарии<br>
                <hr>
                <button class="btn btn-sm btn-success mt-2" type="button" data-toggle="collapse" data-target="#api-20" aria-expanded="false" aria-controls="api-20">Ответ 200</button>
                <div class="collapse mt-2" id="api-20" style="font-size: 10px; line-height: 1; white-space: pre;">
                    {
        "data": {
            "id": 22,
            "organization": {
                "id": 1,
                "rating": null,
                "image": null,
                "title": "Opetit",
                "title_kz": null,
                "title_en": null,
                "description": null,
                "description_kz": null,
                "description_en": null,
                "address": "Байтурсынова 16",
                "address_kz": null,
                "address_en": null,
                "price": null,
                "tables": null,
                "monday": {
                    "start": "00:00:00",
                    "end": "00:00:00"
                },
                "tuesday": {
                    "start": "00:00:00",
                    "end": "00:00:00"
                },
                "wednesday": {
                    "start": "00:00:00",
                    "end": "00:00:00"
                },
                "thursday": {
                    "start": "00:00:00",
                    "end": "00:00:00"
                },
                "friday": {
                    "start": "00:00:00",
                    "end": "00:00:00"
                },
                "saturday": {
                    "start": "00:00:00",
                    "end": "00:00:00"
                },
                "sunday": {
                    "start": "00:00:00",
                    "end": "00:00:00"
                },
                "status": "Включен",
                "user_id": {
                    "id": 1,
                    "blocked": "Активный",
                    "name": "Ersa",
                    "avatar": null,
                    "phone": "77784139424",
                    "phone_verified_at": "Подтвержден (1 неделю назад)",
                    "email": null,
                    "email_verified_at": "Не подтвержден",
                    "api_token": "qwerty01"
                },
                "category_id": {
                    "id": 1,
                    "title": "Ресторан",
                    "title_kz": "Мейрамхана",
                    "title_en": "Restaurant"
                },
                "images": [
                    {
                        "id": 1,
                        "image": "uploads/34cb86ef60c03c0a24c11a906580a7ec.jpg"
                    },
                    {
                        "id": 2,
                        "image": "uploads/77f1cf5e6e11b08ccbe9b043260b27cf.jpg"
                    }
                ]
            },
            "user": {
                "id": 1,
                "blocked": "Активный",
                "name": "Ersa",
                "avatar": null,
                "phone": "77784139424",
                "phone_verified_at": "Подтвержден (1 неделю назад)",
                "email": null,
                "email_verified_at": "Не подтвержден",
                "api_token": "qwerty01"
            },
            "rating": 5,
            "comment": "test comment",
            "status": "На проверке"
        }
    }
                </div>',
            ]
            ],
            ['type' =>  'card', 'class'   => 'card bg-warning text-white', 'content'   =>  [
                'header' => 'Редактировать отзыв по ID', // optional
                'body'   => '<b>Запрос POST</b><br>
                https://'.$_SERVER['HTTP_HOST'].'/api/review/update/{id}<br>
                <b>Параметры</b><br>
                <span class="text-dark">{id}</span> ID отзыва<br>
                <b>POST параметры</b><br>
                <span class="text-dark">rating</span> рейтинг (1-5)<br>
                <span class="text-dark">comment</span> Комментарии<br>
                <hr>
                <button class="btn btn-sm btn-success mt-2" type="button" data-toggle="collapse" data-target="#api-21" aria-expanded="false" aria-controls="api-21">Ответ 200</button>
                <div class="collapse mt-2" id="api-21" style="font-size: 10px; line-height: 1; white-space: pre;">
                    {
        "data": {
            "id": 22,
            "organization": {
                "id": 1,
                "rating": null,
                "image": null,
                "title": "Opetit",
                "title_kz": null,
                "title_en": null,
                "description": null,
                "description_kz": null,
                "description_en": null,
                "address": "Байтурсынова 16",
                "address_kz": null,
                "address_en": null,
                "price": null,
                "tables": null,
                "monday": {
                    "start": "00:00:00",
                    "end": "00:00:00"
                },
                "tuesday": {
                    "start": "00:00:00",
                    "end": "00:00:00"
                },
                "wednesday": {
                    "start": "00:00:00",
                    "end": "00:00:00"
                },
                "thursday": {
                    "start": "00:00:00",
                    "end": "00:00:00"
                },
                "friday": {
                    "start": "00:00:00",
                    "end": "00:00:00"
                },
                "saturday": {
                    "start": "00:00:00",
                    "end": "00:00:00"
                },
                "sunday": {
                    "start": "00:00:00",
                    "end": "00:00:00"
                },
                "status": "Включен",
                "user_id": {
                    "id": 1,
                    "blocked": "Активный",
                    "name": "Ersa",
                    "avatar": null,
                    "phone": "77784139424",
                    "phone_verified_at": "Подтвержден (1 неделю назад)",
                    "email": null,
                    "email_verified_at": "Не подтвержден",
                    "api_token": "qwerty01"
                },
                "category_id": {
                    "id": 1,
                    "title": "Ресторан",
                    "title_kz": "Мейрамхана",
                    "title_en": "Restaurant"
                },
                "images": [
                    {
                        "id": 1,
                        "image": "uploads/34cb86ef60c03c0a24c11a906580a7ec.jpg"
                    },
                    {
                        "id": 2,
                        "image": "uploads/77f1cf5e6e11b08ccbe9b043260b27cf.jpg"
                    }
                ]
            },
            "user": {
                "id": 1,
                "blocked": "Активный",
                "name": "Ersa",
                "avatar": null,
                "phone": "77784139424",
                "phone_verified_at": "Подтвержден (1 неделю назад)",
                "email": null,
                "email_verified_at": "Не подтвержден",
                "api_token": "qwerty01"
            },
            "rating": 5,
            "comment": "test comment",
            "status": "На проверке"
        }
    }
                </div>',
            ]
            ],
            ['type' =>  'card', 'class'   => 'card bg-warning text-white', 'content'   =>  [
                'header' => 'Удалить отзыв по ID', // optional
                'body'   => '<b>Запрос GET</b><br>
                https://'.$_SERVER['HTTP_HOST'].'/api/review/update/{id}<br>
                <b>Параметры</b><br>
                <span class="text-dark">{id}</span> ID отзыва<br>
                <hr>
                <button class="btn btn-sm btn-success mt-2" type="button" data-toggle="collapse" data-target="#api-22" aria-expanded="false" aria-controls="api-22">Ответ 200</button>
                <div class="collapse mt-2" id="api-22" style="font-size: 10px; line-height: 1; white-space: pre;">
                </div>',
            ]
            ],
            ['type' =>  'card', 'class'   => 'card bg-warning text-white', 'content'   =>  [
                'header' => 'Получить все отзывы по ID организации', // optional
                'body'   => '<b>Запрос GET</b><br>
                https://'.$_SERVER['HTTP_HOST'].'/api/review/list/organization/{id}<br>
                <b>Параметры</b><br>
                <span class="text-dark">{id}</span> ID организации<br>
                <b>Дополнительные параметры</b><br>
                <span class="text-dark">?paginate=1</span> в одном запросе 15 результата<br>
                <hr>
                <button class="btn btn-sm btn-success mt-2" type="button" data-toggle="collapse" data-target="#api-23" aria-expanded="false" aria-controls="api-23">Ответ 200</button>
                <div class="collapse mt-2" id="api-23" style="font-size: 10px; line-height: 1; white-space: pre;">
                {
        "data": [
            {
                "id": 16,
                "organization": {
                    "id": 1,
                    "rating": null,
                    "image": null,
                    "title": "Opetit",
                    "title_kz": null,
                    "title_en": null,
                    "description": null,
                    "description_kz": null,
                    "description_en": null,
                    "address": "Байтурсынова 16",
                    "address_kz": null,
                    "address_en": null,
                    "price": null,
                    "tables": null,
                    "monday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "tuesday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "wednesday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "thursday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "friday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "saturday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "sunday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "status": "Включен",
                    "user_id": {
                        "id": 1,
                        "blocked": "Активный",
                        "name": "Ersa",
                        "avatar": null,
                        "phone": "77784139424",
                        "phone_verified_at": "Подтвержден (1 неделю назад)",
                        "email": null,
                        "email_verified_at": "Не подтвержден",
                        "api_token": "qwerty01"
                    },
                    "category_id": {
                        "id": 1,
                        "title": "Ресторан",
                        "title_kz": "Мейрамхана",
                        "title_en": "Restaurant"
                    },
                    "images": [
                        {
                            "id": 1,
                            "image": "uploads/34cb86ef60c03c0a24c11a906580a7ec.jpg"
                        },
                        {
                            "id": 2,
                            "image": "uploads/77f1cf5e6e11b08ccbe9b043260b27cf.jpg"
                        }
                    ]
                },
                "user": {
                    "id": 1,
                    "blocked": "Активный",
                    "name": "Ersa",
                    "avatar": null,
                    "phone": "77784139424",
                    "phone_verified_at": "Подтвержден (1 неделю назад)",
                    "email": null,
                    "email_verified_at": "Не подтвержден",
                    "api_token": "qwerty01"
                },
                "rating": 3,
                "comment": "hello world",
                "status": "На проверке"
            },
            {
                "id": 17,
                "organization": {
                    "id": 1,
                    "rating": null,
                    "image": null,
                    "title": "Opetit",
                    "title_kz": null,
                    "title_en": null,
                    "description": null,
                    "description_kz": null,
                    "description_en": null,
                    "address": "Байтурсынова 16",
                    "address_kz": null,
                    "address_en": null,
                    "price": null,
                    "tables": null,
                    "monday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "tuesday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "wednesday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "thursday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "friday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "saturday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "sunday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "status": "Включен",
                    "user_id": {
                        "id": 1,
                        "blocked": "Активный",
                        "name": "Ersa",
                        "avatar": null,
                        "phone": "77784139424",
                        "phone_verified_at": "Подтвержден (1 неделю назад)",
                        "email": null,
                        "email_verified_at": "Не подтвержден",
                        "api_token": "qwerty01"
                    },
                    "category_id": {
                        "id": 1,
                        "title": "Ресторан",
                        "title_kz": "Мейрамхана",
                        "title_en": "Restaurant"
                    },
                    "images": [
                        {
                            "id": 1,
                            "image": "uploads/34cb86ef60c03c0a24c11a906580a7ec.jpg"
                        },
                        {
                            "id": 2,
                            "image": "uploads/77f1cf5e6e11b08ccbe9b043260b27cf.jpg"
                        }
                    ]
                },
                "user": {
                    "id": 1,
                    "blocked": "Активный",
                    "name": "Ersa",
                    "avatar": null,
                    "phone": "77784139424",
                    "phone_verified_at": "Подтвержден (1 неделю назад)",
                    "email": null,
                    "email_verified_at": "Не подтвержден",
                    "api_token": "qwerty01"
                },
                "rating": 3,
                "comment": "hello world",
                "status": "На проверке"
            },
            {
                "id": 18,
                "organization": {
                    "id": 1,
                    "rating": null,
                    "image": null,
                    "title": "Opetit",
                    "title_kz": null,
                    "title_en": null,
                    "description": null,
                    "description_kz": null,
                    "description_en": null,
                    "address": "Байтурсынова 16",
                    "address_kz": null,
                    "address_en": null,
                    "price": null,
                    "tables": null,
                    "monday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "tuesday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "wednesday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "thursday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "friday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "saturday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "sunday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "status": "Включен",
                    "user_id": {
                        "id": 1,
                        "blocked": "Активный",
                        "name": "Ersa",
                        "avatar": null,
                        "phone": "77784139424",
                        "phone_verified_at": "Подтвержден (1 неделю назад)",
                        "email": null,
                        "email_verified_at": "Не подтвержден",
                        "api_token": "qwerty01"
                    },
                    "category_id": {
                        "id": 1,
                        "title": "Ресторан",
                        "title_kz": "Мейрамхана",
                        "title_en": "Restaurant"
                    },
                    "images": [
                        {
                            "id": 1,
                            "image": "uploads/34cb86ef60c03c0a24c11a906580a7ec.jpg"
                        },
                        {
                            "id": 2,
                            "image": "uploads/77f1cf5e6e11b08ccbe9b043260b27cf.jpg"
                        }
                    ]
                },
                "user": null,
                "rating": 5,
                "comment": "test comment",
                "status": "На проверке"
            },
            {
                "id": 19,
                "organization": {
                    "id": 1,
                    "rating": null,
                    "image": null,
                    "title": "Opetit",
                    "title_kz": null,
                    "title_en": null,
                    "description": null,
                    "description_kz": null,
                    "description_en": null,
                    "address": "Байтурсынова 16",
                    "address_kz": null,
                    "address_en": null,
                    "price": null,
                    "tables": null,
                    "monday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "tuesday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "wednesday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "thursday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "friday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "saturday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "sunday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "status": "Включен",
                    "user_id": {
                        "id": 1,
                        "blocked": "Активный",
                        "name": "Ersa",
                        "avatar": null,
                        "phone": "77784139424",
                        "phone_verified_at": "Подтвержден (1 неделю назад)",
                        "email": null,
                        "email_verified_at": "Не подтвержден",
                        "api_token": "qwerty01"
                    },
                    "category_id": {
                        "id": 1,
                        "title": "Ресторан",
                        "title_kz": "Мейрамхана",
                        "title_en": "Restaurant"
                    },
                    "images": [
                        {
                            "id": 1,
                            "image": "uploads/34cb86ef60c03c0a24c11a906580a7ec.jpg"
                        },
                        {
                            "id": 2,
                            "image": "uploads/77f1cf5e6e11b08ccbe9b043260b27cf.jpg"
                        }
                    ]
                },
                "user": {
                    "id": 1,
                    "blocked": "Активный",
                    "name": "Ersa",
                    "avatar": null,
                    "phone": "77784139424",
                    "phone_verified_at": "Подтвержден (1 неделю назад)",
                    "email": null,
                    "email_verified_at": "Не подтвержден",
                    "api_token": "qwerty01"
                },
                "rating": 5,
                "comment": "test comment",
                "status": "На проверке"
            },
            {
                "id": 20,
                "organization": {
                    "id": 1,
                    "rating": null,
                    "image": null,
                    "title": "Opetit",
                    "title_kz": null,
                    "title_en": null,
                    "description": null,
                    "description_kz": null,
                    "description_en": null,
                    "address": "Байтурсынова 16",
                    "address_kz": null,
                    "address_en": null,
                    "price": null,
                    "tables": null,
                    "monday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "tuesday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "wednesday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "thursday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "friday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "saturday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "sunday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "status": "Включен",
                    "user_id": {
                        "id": 1,
                        "blocked": "Активный",
                        "name": "Ersa",
                        "avatar": null,
                        "phone": "77784139424",
                        "phone_verified_at": "Подтвержден (1 неделю назад)",
                        "email": null,
                        "email_verified_at": "Не подтвержден",
                        "api_token": "qwerty01"
                    },
                    "category_id": {
                        "id": 1,
                        "title": "Ресторан",
                        "title_kz": "Мейрамхана",
                        "title_en": "Restaurant"
                    },
                    "images": [
                        {
                            "id": 1,
                            "image": "uploads/34cb86ef60c03c0a24c11a906580a7ec.jpg"
                        },
                        {
                            "id": 2,
                            "image": "uploads/77f1cf5e6e11b08ccbe9b043260b27cf.jpg"
                        }
                    ]
                },
                "user": {
                    "id": 1,
                    "blocked": "Активный",
                    "name": "Ersa",
                    "avatar": null,
                    "phone": "77784139424",
                    "phone_verified_at": "Подтвержден (1 неделю назад)",
                    "email": null,
                    "email_verified_at": "Не подтвержден",
                    "api_token": "qwerty01"
                },
                "rating": 5,
                "comment": "test comment",
                "status": "На проверке"
            },
            {
                "id": 21,
                "organization": {
                    "id": 1,
                    "rating": null,
                    "image": null,
                    "title": "Opetit",
                    "title_kz": null,
                    "title_en": null,
                    "description": null,
                    "description_kz": null,
                    "description_en": null,
                    "address": "Байтурсынова 16",
                    "address_kz": null,
                    "address_en": null,
                    "price": null,
                    "tables": null,
                    "monday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "tuesday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "wednesday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "thursday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "friday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "saturday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "sunday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "status": "Включен",
                    "user_id": {
                        "id": 1,
                        "blocked": "Активный",
                        "name": "Ersa",
                        "avatar": null,
                        "phone": "77784139424",
                        "phone_verified_at": "Подтвержден (1 неделю назад)",
                        "email": null,
                        "email_verified_at": "Не подтвержден",
                        "api_token": "qwerty01"
                    },
                    "category_id": {
                        "id": 1,
                        "title": "Ресторан",
                        "title_kz": "Мейрамхана",
                        "title_en": "Restaurant"
                    },
                    "images": [
                        {
                            "id": 1,
                            "image": "uploads/34cb86ef60c03c0a24c11a906580a7ec.jpg"
                        },
                        {
                            "id": 2,
                            "image": "uploads/77f1cf5e6e11b08ccbe9b043260b27cf.jpg"
                        }
                    ]
                },
                "user": {
                    "id": 1,
                    "blocked": "Активный",
                    "name": "Ersa",
                    "avatar": null,
                    "phone": "77784139424",
                    "phone_verified_at": "Подтвержден (1 неделю назад)",
                    "email": null,
                    "email_verified_at": "Не подтвержден",
                    "api_token": "qwerty01"
                },
                "rating": 5,
                "comment": "test comment",
                "status": "На проверке"
            },
            {
                "id": 22,
                "organization": {
                    "id": 1,
                    "rating": null,
                    "image": null,
                    "title": "Opetit",
                    "title_kz": null,
                    "title_en": null,
                    "description": null,
                    "description_kz": null,
                    "description_en": null,
                    "address": "Байтурсынова 16",
                    "address_kz": null,
                    "address_en": null,
                    "price": null,
                    "tables": null,
                    "monday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "tuesday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "wednesday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "thursday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "friday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "saturday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "sunday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "status": "Включен",
                    "user_id": {
                        "id": 1,
                        "blocked": "Активный",
                        "name": "Ersa",
                        "avatar": null,
                        "phone": "77784139424",
                        "phone_verified_at": "Подтвержден (1 неделю назад)",
                        "email": null,
                        "email_verified_at": "Не подтвержден",
                        "api_token": "qwerty01"
                    },
                    "category_id": {
                        "id": 1,
                        "title": "Ресторан",
                        "title_kz": "Мейрамхана",
                        "title_en": "Restaurant"
                    },
                    "images": [
                        {
                            "id": 1,
                            "image": "uploads/34cb86ef60c03c0a24c11a906580a7ec.jpg"
                        },
                        {
                            "id": 2,
                            "image": "uploads/77f1cf5e6e11b08ccbe9b043260b27cf.jpg"
                        }
                    ]
                },
                "user": {
                    "id": 1,
                    "blocked": "Активный",
                    "name": "Ersa",
                    "avatar": null,
                    "phone": "77784139424",
                    "phone_verified_at": "Подтвержден (1 неделю назад)",
                    "email": null,
                    "email_verified_at": "Не подтвержден",
                    "api_token": "qwerty01"
                },
                "rating": 5,
                "comment": "test comment",
                "status": "На проверке"
            }
        ]
    }
                </div>',
            ]
            ],
            ['type' =>  'card', 'class'   => 'card bg-warning text-white', 'content'   =>  [
                'header' => 'Получить все отзывы по ID пользователя', // optional
                'body'   => '<b>Запрос GET</b><br>
                https://'.$_SERVER['HTTP_HOST'].'/api/review/list/user/{id}<br>
                <b>Параметры</b><br>
                <span class="text-dark">{id}</span> ID пользователя<br>
                <b>Дополнительные параметры</b><br>
                <span class="text-dark">?paginate=1</span> в одном запросе 15 результата<br>
                <hr>
                <button class="btn btn-sm btn-success mt-2" type="button" data-toggle="collapse" data-target="#api-24" aria-expanded="false" aria-controls="api-24">Ответ 200</button>
                <div class="collapse mt-2" id="api-24" style="font-size: 10px; line-height: 1; white-space: pre;">
                {
        "data": [
            {
                "id": 16,
                "organization": {
                    "id": 1,
                    "rating": null,
                    "image": null,
                    "title": "Opetit",
                    "title_kz": null,
                    "title_en": null,
                    "description": null,
                    "description_kz": null,
                    "description_en": null,
                    "address": "Байтурсынова 16",
                    "address_kz": null,
                    "address_en": null,
                    "price": null,
                    "tables": null,
                    "monday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "tuesday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "wednesday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "thursday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "friday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "saturday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "sunday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "status": "Включен",
                    "user_id": {
                        "id": 1,
                        "blocked": "Активный",
                        "name": "Ersa",
                        "avatar": null,
                        "phone": "77784139424",
                        "phone_verified_at": "Подтвержден (1 неделю назад)",
                        "email": null,
                        "email_verified_at": "Не подтвержден",
                        "api_token": "qwerty01"
                    },
                    "category_id": {
                        "id": 1,
                        "title": "Ресторан",
                        "title_kz": "Мейрамхана",
                        "title_en": "Restaurant"
                    },
                    "images": [
                        {
                            "id": 1,
                            "image": "uploads/34cb86ef60c03c0a24c11a906580a7ec.jpg"
                        },
                        {
                            "id": 2,
                            "image": "uploads/77f1cf5e6e11b08ccbe9b043260b27cf.jpg"
                        }
                    ]
                },
                "user": {
                    "id": 1,
                    "blocked": "Активный",
                    "name": "Ersa",
                    "avatar": null,
                    "phone": "77784139424",
                    "phone_verified_at": "Подтвержден (1 неделю назад)",
                    "email": null,
                    "email_verified_at": "Не подтвержден",
                    "api_token": "qwerty01"
                },
                "rating": 3,
                "comment": "hello world",
                "status": "На проверке"
            },
            {
                "id": 17,
                "organization": {
                    "id": 1,
                    "rating": null,
                    "image": null,
                    "title": "Opetit",
                    "title_kz": null,
                    "title_en": null,
                    "description": null,
                    "description_kz": null,
                    "description_en": null,
                    "address": "Байтурсынова 16",
                    "address_kz": null,
                    "address_en": null,
                    "price": null,
                    "tables": null,
                    "monday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "tuesday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "wednesday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "thursday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "friday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "saturday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "sunday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "status": "Включен",
                    "user_id": {
                        "id": 1,
                        "blocked": "Активный",
                        "name": "Ersa",
                        "avatar": null,
                        "phone": "77784139424",
                        "phone_verified_at": "Подтвержден (1 неделю назад)",
                        "email": null,
                        "email_verified_at": "Не подтвержден",
                        "api_token": "qwerty01"
                    },
                    "category_id": {
                        "id": 1,
                        "title": "Ресторан",
                        "title_kz": "Мейрамхана",
                        "title_en": "Restaurant"
                    },
                    "images": [
                        {
                            "id": 1,
                            "image": "uploads/34cb86ef60c03c0a24c11a906580a7ec.jpg"
                        },
                        {
                            "id": 2,
                            "image": "uploads/77f1cf5e6e11b08ccbe9b043260b27cf.jpg"
                        }
                    ]
                },
                "user": {
                    "id": 1,
                    "blocked": "Активный",
                    "name": "Ersa",
                    "avatar": null,
                    "phone": "77784139424",
                    "phone_verified_at": "Подтвержден (1 неделю назад)",
                    "email": null,
                    "email_verified_at": "Не подтвержден",
                    "api_token": "qwerty01"
                },
                "rating": 3,
                "comment": "hello world",
                "status": "На проверке"
            },
            {
                "id": 18,
                "organization": {
                    "id": 1,
                    "rating": null,
                    "image": null,
                    "title": "Opetit",
                    "title_kz": null,
                    "title_en": null,
                    "description": null,
                    "description_kz": null,
                    "description_en": null,
                    "address": "Байтурсынова 16",
                    "address_kz": null,
                    "address_en": null,
                    "price": null,
                    "tables": null,
                    "monday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "tuesday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "wednesday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "thursday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "friday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "saturday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "sunday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "status": "Включен",
                    "user_id": {
                        "id": 1,
                        "blocked": "Активный",
                        "name": "Ersa",
                        "avatar": null,
                        "phone": "77784139424",
                        "phone_verified_at": "Подтвержден (1 неделю назад)",
                        "email": null,
                        "email_verified_at": "Не подтвержден",
                        "api_token": "qwerty01"
                    },
                    "category_id": {
                        "id": 1,
                        "title": "Ресторан",
                        "title_kz": "Мейрамхана",
                        "title_en": "Restaurant"
                    },
                    "images": [
                        {
                            "id": 1,
                            "image": "uploads/34cb86ef60c03c0a24c11a906580a7ec.jpg"
                        },
                        {
                            "id": 2,
                            "image": "uploads/77f1cf5e6e11b08ccbe9b043260b27cf.jpg"
                        }
                    ]
                },
                "user": null,
                "rating": 5,
                "comment": "test comment",
                "status": "На проверке"
            },
            {
                "id": 19,
                "organization": {
                    "id": 1,
                    "rating": null,
                    "image": null,
                    "title": "Opetit",
                    "title_kz": null,
                    "title_en": null,
                    "description": null,
                    "description_kz": null,
                    "description_en": null,
                    "address": "Байтурсынова 16",
                    "address_kz": null,
                    "address_en": null,
                    "price": null,
                    "tables": null,
                    "monday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "tuesday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "wednesday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "thursday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "friday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "saturday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "sunday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "status": "Включен",
                    "user_id": {
                        "id": 1,
                        "blocked": "Активный",
                        "name": "Ersa",
                        "avatar": null,
                        "phone": "77784139424",
                        "phone_verified_at": "Подтвержден (1 неделю назад)",
                        "email": null,
                        "email_verified_at": "Не подтвержден",
                        "api_token": "qwerty01"
                    },
                    "category_id": {
                        "id": 1,
                        "title": "Ресторан",
                        "title_kz": "Мейрамхана",
                        "title_en": "Restaurant"
                    },
                    "images": [
                        {
                            "id": 1,
                            "image": "uploads/34cb86ef60c03c0a24c11a906580a7ec.jpg"
                        },
                        {
                            "id": 2,
                            "image": "uploads/77f1cf5e6e11b08ccbe9b043260b27cf.jpg"
                        }
                    ]
                },
                "user": {
                    "id": 1,
                    "blocked": "Активный",
                    "name": "Ersa",
                    "avatar": null,
                    "phone": "77784139424",
                    "phone_verified_at": "Подтвержден (1 неделю назад)",
                    "email": null,
                    "email_verified_at": "Не подтвержден",
                    "api_token": "qwerty01"
                },
                "rating": 5,
                "comment": "test comment",
                "status": "На проверке"
            },
            {
                "id": 20,
                "organization": {
                    "id": 1,
                    "rating": null,
                    "image": null,
                    "title": "Opetit",
                    "title_kz": null,
                    "title_en": null,
                    "description": null,
                    "description_kz": null,
                    "description_en": null,
                    "address": "Байтурсынова 16",
                    "address_kz": null,
                    "address_en": null,
                    "price": null,
                    "tables": null,
                    "monday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "tuesday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "wednesday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "thursday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "friday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "saturday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "sunday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "status": "Включен",
                    "user_id": {
                        "id": 1,
                        "blocked": "Активный",
                        "name": "Ersa",
                        "avatar": null,
                        "phone": "77784139424",
                        "phone_verified_at": "Подтвержден (1 неделю назад)",
                        "email": null,
                        "email_verified_at": "Не подтвержден",
                        "api_token": "qwerty01"
                    },
                    "category_id": {
                        "id": 1,
                        "title": "Ресторан",
                        "title_kz": "Мейрамхана",
                        "title_en": "Restaurant"
                    },
                    "images": [
                        {
                            "id": 1,
                            "image": "uploads/34cb86ef60c03c0a24c11a906580a7ec.jpg"
                        },
                        {
                            "id": 2,
                            "image": "uploads/77f1cf5e6e11b08ccbe9b043260b27cf.jpg"
                        }
                    ]
                },
                "user": {
                    "id": 1,
                    "blocked": "Активный",
                    "name": "Ersa",
                    "avatar": null,
                    "phone": "77784139424",
                    "phone_verified_at": "Подтвержден (1 неделю назад)",
                    "email": null,
                    "email_verified_at": "Не подтвержден",
                    "api_token": "qwerty01"
                },
                "rating": 5,
                "comment": "test comment",
                "status": "На проверке"
            },
            {
                "id": 21,
                "organization": {
                    "id": 1,
                    "rating": null,
                    "image": null,
                    "title": "Opetit",
                    "title_kz": null,
                    "title_en": null,
                    "description": null,
                    "description_kz": null,
                    "description_en": null,
                    "address": "Байтурсынова 16",
                    "address_kz": null,
                    "address_en": null,
                    "price": null,
                    "tables": null,
                    "monday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "tuesday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "wednesday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "thursday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "friday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "saturday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "sunday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "status": "Включен",
                    "user_id": {
                        "id": 1,
                        "blocked": "Активный",
                        "name": "Ersa",
                        "avatar": null,
                        "phone": "77784139424",
                        "phone_verified_at": "Подтвержден (1 неделю назад)",
                        "email": null,
                        "email_verified_at": "Не подтвержден",
                        "api_token": "qwerty01"
                    },
                    "category_id": {
                        "id": 1,
                        "title": "Ресторан",
                        "title_kz": "Мейрамхана",
                        "title_en": "Restaurant"
                    },
                    "images": [
                        {
                            "id": 1,
                            "image": "uploads/34cb86ef60c03c0a24c11a906580a7ec.jpg"
                        },
                        {
                            "id": 2,
                            "image": "uploads/77f1cf5e6e11b08ccbe9b043260b27cf.jpg"
                        }
                    ]
                },
                "user": {
                    "id": 1,
                    "blocked": "Активный",
                    "name": "Ersa",
                    "avatar": null,
                    "phone": "77784139424",
                    "phone_verified_at": "Подтвержден (1 неделю назад)",
                    "email": null,
                    "email_verified_at": "Не подтвержден",
                    "api_token": "qwerty01"
                },
                "rating": 5,
                "comment": "test comment",
                "status": "На проверке"
            },
            {
                "id": 22,
                "organization": {
                    "id": 1,
                    "rating": null,
                    "image": null,
                    "title": "Opetit",
                    "title_kz": null,
                    "title_en": null,
                    "description": null,
                    "description_kz": null,
                    "description_en": null,
                    "address": "Байтурсынова 16",
                    "address_kz": null,
                    "address_en": null,
                    "price": null,
                    "tables": null,
                    "monday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "tuesday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "wednesday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "thursday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "friday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "saturday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "sunday": {
                        "start": "00:00:00",
                        "end": "00:00:00"
                    },
                    "status": "Включен",
                    "user_id": {
                        "id": 1,
                        "blocked": "Активный",
                        "name": "Ersa",
                        "avatar": null,
                        "phone": "77784139424",
                        "phone_verified_at": "Подтвержден (1 неделю назад)",
                        "email": null,
                        "email_verified_at": "Не подтвержден",
                        "api_token": "qwerty01"
                    },
                    "category_id": {
                        "id": 1,
                        "title": "Ресторан",
                        "title_kz": "Мейрамхана",
                        "title_en": "Restaurant"
                    },
                    "images": [
                        {
                            "id": 1,
                            "image": "uploads/34cb86ef60c03c0a24c11a906580a7ec.jpg"
                        },
                        {
                            "id": 2,
                            "image": "uploads/77f1cf5e6e11b08ccbe9b043260b27cf.jpg"
                        }
                    ]
                },
                "user": {
                    "id": 1,
                    "blocked": "Активный",
                    "name": "Ersa",
                    "avatar": null,
                    "phone": "77784139424",
                    "phone_verified_at": "Подтвержден (1 неделю назад)",
                    "email": null,
                    "email_verified_at": "Не подтвержден",
                    "api_token": "qwerty01"
                },
                "rating": 5,
                "comment": "test comment",
                "status": "На проверке"
            }
        ]
    }
                </div>',
            ]
            ],
            ]
        ];
    @endphp
@section('content')
@endsection
@else
@section('content')
    <div id="tables">
        @include('vendor.backpack.base.card.list', [
            'date'      =>  '',
            'organization'  =>  $organizationService->getByUserId(backpack_auth()->user()->id),
            'user_id'   =>  backpack_auth()->user()->id,
            'userService'   =>  $userService,
            'organizationService'   =>  $organizationService,
            'organizationTableService'    =>  $organizationTableService,
            'organizationTableListService'      =>  $organizationTableListService,
            'bookingService'    =>  $bookingService
        ])
    </div>
    <script>
        $(document.body).on('click', '.booking-new-btn', function() {
            $("#booking-modal").attr('data-id',$(this).attr('data-id'));
            $("#booking-modal").attr('data-organization',$(this).closest('.card-body').attr('data-id'));
            $("#booking-modal").attr('data-user',$(this).closest('.card-body').attr('data-user'));
        });

        $(document.body).on('click', '.btn-booking', function() {
            $.get('booking/status/'+$(this).attr('data-id'));
        });

        $(document.body).on('click', '.btn-booking-came', function() {
            $.post('/api/booking/update/'+$(this).attr('data-id'), {
                'status':'came'
            });
        });

        $(document.body).on('click', '.btn-booking-completed', function() {
            $.post('/api/booking/update/'+$(this).attr('data-id'), {
                'status':'COMPLETED'
            });
        });

        $(document.body).on('click', '.card-toggle-btn', function() {
            let status  =   $(this).attr('data-status');
            let id      =   $(this).attr('data-id');
            if (status === 'ENABLED') {
                $(this).attr('data-status','FROZEN').removeClass('card-toggle-btn-success').addClass('card-toggle-btn-locked');
                $.post('/api/table/update/'+id, {
                    'status':'FROZEN'
                });
            } else {
                $(this).attr('data-status','ENABLED').removeClass('card-toggle-btn-locked').addClass('card-toggle-btn-success');
                $.post('/api/table/update/'+id, {
                    'status':'ENABLED'
                });
            }
        });

    </script>
    <style>
        .card-toggle-btn {
            position: absolute;
            width: 40px;
            height: 40px;
            background: #fff;
            box-shadow: 0 .5rem 1rem rgba(22,28,45,.15)!important;
            right: -20px;
            top: -20px;
            border-radius: 40px;
            cursor: pointer;
        }
        .card-toggle-btn-success {
            background: #fff url('/img/logo/check-mark.svg') no-repeat center;
            background-size: 50%;
        }
        .card-toggle-btn-locked {
            background: #fff url('/img/logo/padlock.svg') no-repeat center;
            background-size: 50%;
        }
    </style>
@endsection
@endif
