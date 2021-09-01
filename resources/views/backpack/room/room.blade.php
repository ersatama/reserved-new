@extends(backpack_view('blank'))
@section('content')
    <link href="{{ asset('css/room.css') }}" rel="stylesheet">
    <div id="app">
        <div class="room">
            <input type="hidden" id="organization" value="{{$id}}">
            <div class="room-main">
                <div class="room-title">
                    Комнаты
                    <span v-if="sections.length > 0">(@{{ sections.length }})</span>
                    <button class="room-btn" @click="newRooms(0)">Добавить комнату</button>
                </div>
                <div class="room-table">
                    <div class="room-table-header">
                        <div class="room-table-header-item room-table-item-id">ID</div>
                        <div class="room-table-header-item room-table-item-name">Название</div>
                        <div class="room-table-header-item room-table-item-status">Статус</div>
                        <div class="room-table-header-item room-table-item-created">Создан</div>
                        <div class="room-table-header-item room-table-item-action">Действия</div>
                    </div>
                    <div class="room-table-body">
                        <div class="room-table-list" v-if="sections.length > 0" v-for="(section,key) in sections" :key="key">
                            <div class="room-table-body-item room-table-item-id">@{{section.id}}</div>
                            <div class="room-table-body-item room-table-item-name">@{{section.name}}</div>
                            <div class="room-table-body-item room-table-item-status bg-enabled" v-if="section.status === 'ENABLED'" @click="statusRoom('FROZEN',key)">Включен</div>
                            <div class="room-table-body-item room-table-item-status bg-disabled" v-else @click="statusRoom('ENABLED',key)">Отключен</div>
                            <div class="room-table-body-item room-table-item-created">@{{ section.created_at }}</div>
                            <div class="room-table-header-item room-table-item-action">
                                <div class="room-table-header-item room-table-item-statistics"></div>
                                <div class="room-table-header-item room-table-item-edit" @click="editRoom(1,key)"></div>
                                <div class="room-table-header-item room-table-item-unlocked" v-if="section.status === 'ENABLED'" @click="statusRoom('FROZEN',key)"></div>
                                <div class="room-table-header-item room-table-item-delete" v-else @click="statusRoom('ENABLED',key)"></div>
                            </div>
                        </div>
                        <div class="room-table-empty" v-else>
                            Список пуст
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="room" v-for="(section,key) in sections" :key="key" v-if="section.status === 'ENABLED'">
            <div class="room-main">
                <div class="room-title">
                    @{{ section.name }} <span v-if="section.organization_tables.length > 0">(@{{ section.organization_tables.length }})</span>
                    <button class="room-btn" @click="newTable(2,key)">Добавить стол</button>
                </div>
                <div class="room-table">
                    <div class="room-table-header">
                        <div class="room-table-header-item room-table-item-id">ID</div>
                        <div class="room-table-header-item room-table-item-name">Название</div>
                        <div class="room-table-header-item room-table-item-status">Статус</div>
                        <div class="room-table-header-item room-table-item-created">Лимит/Цена</div>
                        <div class="room-table-header-item room-table-item-action">Действия</div>
                    </div>
                    <div class="room-table-body" v-if="section.organization_tables.length === 0">
                        <div class="room-table-empty">
                            Список пуст
                        </div>
                    </div>
                    <div class="room-table-body" v-else>
                        <div class="room-table-list" v-for="(table,tableKey) in section.organization_tables" :key="tableKey">
                            <div class="room-table-body-item room-table-item-id">@{{table.id}}</div>
                            <div class="room-table-body-item room-table-item-name">@{{table.title}}</div>
                            <div class="room-table-body-item room-table-item-status bg-enabled" v-if="table.status === 'ENABLED'" @click="statusTable('FROZEN',key,tableKey)">Включен</div>
                            <div class="room-table-body-item room-table-item-status bg-disabled" v-else @click="statusTable('ENABLED',key,tableKey)">Отключен</div>
                            <div class="room-table-body-item room-table-item-created">@{{ table.limit }}/@{{ table.price }} </div>
                            <div class="room-table-header-item room-table-item-action">
                                <div class="room-table-header-item room-table-item-duplicate"></div>
                                <div class="room-table-header-item room-table-item-statistics"></div>
                                <div class="room-table-header-item room-table-item-edit" @click="editTable(3,key,tableKey)"></div>
                                <div class="room-table-header-item room-table-item-unlocked" v-if="table.status === 'ENABLED'" @click="statusTable('FROZEN',key,tableKey)"></div>
                                <div class="room-table-header-item room-table-item-delete" v-else @click="statusTable('ENABLED',key,tableKey)"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('backpack.modal.room')
    </div>
    @include('backpack.scripts')
    <script src="{{ asset('js/room.js') }}"></script>
@endsection
