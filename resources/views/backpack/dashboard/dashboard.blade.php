@extends(backpack_view('blank'))
@section('content')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <div id="app">
        <div class="dashboard">
            <audio src="/audio/notification.wav" :autoload="true" id="notification" :mute="true"></audio>
            <input type="hidden" id="user_id" value="{{ $organization->{\App\Domain\Contracts\MainContract::USER_ID} }}">
            <input type="hidden" id="organization" value="{{ $organization->{\App\Domain\Contracts\MainContract::ID} }}">
            <div class="dashboard-main">
                <div class="dashboard-header">
                    <div class="dashboard-title">{{ $organization->{\App\Domain\Contracts\MainContract::TITLE} }}</div>
                </div>
                <div class="dashboard-calendar">
                    <v-date-picker v-model="date" :input-debounce="500">
                        <template v-slot="{ inputValue, inputEvents }">
                            <input class="rounded dashboard-calendar-input" readonly :value="inputValue" v-on="inputEvents" />
                        </template>
                    </v-date-picker>
                </div>
            </div>
        </div>
        <div class="dashboard-blocks" v-if="status">
            <div class="dashboard-block">
                <div class="dashboard-block-title"></div>
                <div class="dashboard-block-description">Список столов этой секции</div>
                <div class="dashboard-block-body">
                    <div class="dashboard-table">
                        <div class="dashboard-table-item">
                            <div class="dashboard-table-title">
                                <div class="dashboard-table-title-loading"></div>
                            </div>
                            <div class="dashboard-table-forms">
                                <div class="dashboard-table-form">
                                    <div class="dashboard-table-description">
                                        <div class="dashboard-table-description-loading"></div>
                                    </div>
                                    <div class="dashboard-table-value">
                                        <div class="dashboard-table-value-loading"></div>
                                    </div>
                                </div>
                                <div class="dashboard-table-form">
                                    <div class="dashboard-table-description">
                                        <div class="dashboard-table-description-loading"></div>
                                    </div>
                                    <div class="dashboard-table-value">
                                        <div class="dashboard-table-value-loading"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="dashboard-table-buttons">
                                <div class="dashboard-table-button-loading"></div>
                            </div>
                        </div>
                    </div>
                    <div class="dashboard-table">
                        <div class="dashboard-table-item">
                            <div class="dashboard-table-title">
                                <div class="dashboard-table-title-loading"></div>
                            </div>
                            <div class="dashboard-table-forms">
                                <div class="dashboard-table-form">
                                    <div class="dashboard-table-description">
                                        <div class="dashboard-table-description-loading"></div>
                                    </div>
                                    <div class="dashboard-table-value">
                                        <div class="dashboard-table-value-loading"></div>
                                    </div>
                                </div>
                                <div class="dashboard-table-form">
                                    <div class="dashboard-table-description">
                                        <div class="dashboard-table-description-loading"></div>
                                    </div>
                                    <div class="dashboard-table-value">
                                        <div class="dashboard-table-value-loading"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="dashboard-table-buttons">
                                <div class="dashboard-table-button-loading"></div>
                            </div>
                        </div>
                    </div>
                    <div class="dashboard-table">
                        <div class="dashboard-table-item">
                            <div class="dashboard-table-title">
                                <div class="dashboard-table-title-loading"></div>
                            </div>
                            <div class="dashboard-table-forms">
                                <div class="dashboard-table-form">
                                    <div class="dashboard-table-description">
                                        <div class="dashboard-table-description-loading"></div>
                                    </div>
                                    <div class="dashboard-table-value">
                                        <div class="dashboard-table-value-loading"></div>
                                    </div>
                                </div>
                                <div class="dashboard-table-form">
                                    <div class="dashboard-table-description">
                                        <div class="dashboard-table-description-loading"></div>
                                    </div>
                                    <div class="dashboard-table-value">
                                        <div class="dashboard-table-value-loading"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="dashboard-table-buttons">
                                <div class="dashboard-table-button-loading"></div>
                            </div>
                        </div>
                    </div>
                    <div class="dashboard-table">
                        <div class="dashboard-table-item">
                            <div class="dashboard-table-title">
                                <div class="dashboard-table-title-loading"></div>
                            </div>
                            <div class="dashboard-table-forms">
                                <div class="dashboard-table-form">
                                    <div class="dashboard-table-description">
                                        <div class="dashboard-table-description-loading"></div>
                                    </div>
                                    <div class="dashboard-table-value">
                                        <div class="dashboard-table-value-loading"></div>
                                    </div>
                                </div>
                                <div class="dashboard-table-form">
                                    <div class="dashboard-table-description">
                                        <div class="dashboard-table-description-loading"></div>
                                    </div>
                                    <div class="dashboard-table-value">
                                        <div class="dashboard-table-value-loading"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="dashboard-table-buttons">
                                <div class="dashboard-table-button-loading"></div>
                            </div>
                        </div>
                    </div>
                    <div class="dashboard-table">
                        <div class="dashboard-table-item">
                            <div class="dashboard-table-title">
                                <div class="dashboard-table-title-loading"></div>
                            </div>
                            <div class="dashboard-table-forms">
                                <div class="dashboard-table-form">
                                    <div class="dashboard-table-description">
                                        <div class="dashboard-table-description-loading"></div>
                                    </div>
                                    <div class="dashboard-table-value">
                                        <div class="dashboard-table-value-loading"></div>
                                    </div>
                                </div>
                                <div class="dashboard-table-form">
                                    <div class="dashboard-table-description">
                                        <div class="dashboard-table-description-loading"></div>
                                    </div>
                                    <div class="dashboard-table-value">
                                        <div class="dashboard-table-value-loading"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="dashboard-table-buttons">
                                <div class="dashboard-table-button-loading"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="dashboard-blocks" v-else>
            <div class="dashboard-block" v-for="(section,key) in sections" :key="key" v-if="section.organization_tables.length > 0">
                <div class="dashboard-block-title">@{{ section.name }}</div>
                <div class="dashboard-block-description">Список столов этой секции</div>
                <div class="dashboard-block-body">
                    <div class="dashboard-table" v-for="(table,tableKey) in section.organization_tables" :key="tableKey">
                        <div class="dashboard-table-item" :class="{'dashboard-table-item-checking':(table.booking && table.booking.status === 'CHECKING'),'dashboard-table-item-on':(table.booking && table.booking.status === 'on'),'dashboard-table-item-came':(table.booking && table.booking.status === 'came')}">
                            <div class="dashboard-table-title">
                                <div class="dashboard-table-title-loading" v-if="table.booking === undefined"></div>
                                <template v-else>@{{ table.title }} </template>
                                <div class="dashboard-lock" :class="{'dashboard-lock-on':(table.status === 'FROZEN')}" @click="tableStatus(key,tableKey)">
                                    <div class="dashboard-lock-btn"></div>
                                </div>
                            </div>
                            <div class="dashboard-table-forms">

                                <template v-if="table.booking === undefined">

                                    <div class="dashboard-table-form">
                                        <div class="dashboard-table-description">
                                            <div class="dashboard-table-description-loading"></div>
                                        </div>
                                        <div class="dashboard-table-value">
                                            <div class="dashboard-table-value-loading"></div>
                                        </div>
                                    </div>
                                    <div class="dashboard-table-form">
                                        <div class="dashboard-table-description">
                                            <div class="dashboard-table-description-loading"></div>
                                        </div>
                                        <div class="dashboard-table-value">
                                            <div class="dashboard-table-value-loading"></div>
                                        </div>
                                    </div>

                                </template>
                                <template v-else-if="table.booking === null">

                                    <div class="dashboard-table-form">
                                        <div class="dashboard-table-description">Вместимость</div>
                                        <div class="dashboard-table-value">@{{ table.limit }} человек</div>
                                    </div>
                                    <div class="dashboard-table-form">
                                        <div class="dashboard-table-description">Депозит</div>
                                        <div class="dashboard-table-value" v-if="table.price > 0">@{{ table.price }} KZT</div>
                                        <div class="dashboard-table-value" v-else>Без депозита</div>
                                    </div>

                                </template>
                                <template v-else-if="table.booking.status === 'CHECKING' || table.booking.status === 'on' || table.booking.status === 'came'">

                                    <div class="dashboard-table-form">
                                        <div class="dashboard-table-description">Имя</div>
                                        <div class="dashboard-table-value">@{{ table.booking.user.name }}</div>
                                    </div>
                                    <div class="dashboard-table-form-double">
                                        <div class="dashboard-table-form">
                                            <div class="dashboard-table-description">Номер</div>
                                            <div class="dashboard-table-value">+@{{ table.booking.user.phone }}</div>
                                        </div>
                                        <div class="dashboard-table-form">
                                            <div class="dashboard-table-description">Время</div>
                                            <div class="dashboard-table-value">@{{ table.booking.time }}</div>
                                        </div>
                                    </div>

                                </template>
                            </div>
                            <div class="dashboard-table-buttons">
                                <div class="dashboard-table-button-loading" v-if="table.booking === undefined"></div>
                                <button class="dashboard-table-button" v-else-if="table.booking === null" @click="startBooking(table)">Забронировать</button>
                                <template v-else-if="table.booking.status === 'CHECKING'">
                                    <button class="dashboard-table-button" @click="cancel(table)">Отмена</button>
                                    <button class="dashboard-table-button dashboard-table-button-transparent">Ожидает оплаты</button>
                                </template>
                                <template v-else-if="table.booking.status === 'on'">
                                    <button class="dashboard-table-button" @click="cancel(table)">Отмена</button>
                                    <button class="dashboard-table-button" @click="came(table)">Гость пришел</button>
                                </template>
                                <template v-else-if="table.booking.status === 'came'">
                                    <button class="dashboard-table-button" @click="cancel(table)">Отмена</button>
                                    <button class="dashboard-table-button" @click="complete(table)">Завершить</button>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('backpack.modal.dashboard')
    </div>
    @include('backpack.scripts')
    <script src="{{ asset('js/dashboard.js') }}" type="module"></script>
@endsection
