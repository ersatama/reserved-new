<link href="{{ asset('css/modal.css') }}" rel="stylesheet">
<template v-if="showModal">
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <template v-if="modalIndex === 0">
                        <div class="modal-header">
                            <slot name="header">
                                Новая комната
                            </slot>
                            <div class="modal-close" @click="showModal = false"></div>
                        </div>
                        <div class="modal-body">
                            <slot name="body">
                                <div class="modal-inputs" v-for="(newSection,key) in newSections" :key="key">
                                    <div class="modal-input-close" v-if="key !== 0 && newSectionsStatus" @click="removeRoom(key)"></div>
                                    <div class="modal-input">
                                        <div>Название комнаты</div>
                                        <input type="text" class="modal-text" ref="newSection" v-model="newSection.name" :disabled="!newSectionsStatus">
                                    </div>
                                    <div class="modal-input">
                                        <div>Статус</div>
                                        <select class="modal-select" v-model="newSection.status" :disabled="!newSectionsStatus">
                                            <option value="ENABLED" :selected="newSection.status === 'ENABLED'">Включен</option>
                                            <option value="FROZEN" :selected="newSection.status === 'FROZEN'">Отключен</option>
                                        </select>
                                    </div>
                                </div>
                            </slot>
                        </div>
                        <div class="modal-footer">
                            <slot name="footer">
                                <button class="modal-additional-button" v-if="newSectionsStatus" @click="addRoom()">
                                    Добавить комнату
                                </button>
                                <button class="modal-default-button" @click="saveRooms()">
                                    Готово
                                </button>
                            </slot>
                        </div>
                    </template>
                    <template v-else-if="modalIndex === 1">
                        <div class="modal-header">
                            <slot name="header">
                                Редактирование комнаты
                            </slot>
                            <div class="modal-close" @click="showModal = false"></div>
                        </div>
                        <div class="modal-body">
                            <slot name="body">
                                <div class="modal-inputs">
                                    <div class="modal-input">
                                        <div>Название комнаты</div>
                                        <input type="text" class="modal-text" ref="editSection" v-model="sections[modalSection].name" :disabled="!newSectionsStatus">
                                    </div>
                                    <div class="modal-input">
                                        <div>Статус</div>
                                        <select class="modal-select" v-model="sections[modalSection].status" :disabled="!newSectionsStatus">
                                            <option value="ENABLED" :selected="sections[modalSection].status === 'ENABLED'">Включен</option>
                                            <option value="FROZEN" :selected="sections[modalSection].status === 'FROZEN'">Отключен</option>
                                        </select>
                                    </div>
                                </div>
                            </slot>
                        </div>
                        <div class="modal-footer">
                            <slot name="footer">
                                <button class="modal-default-button" @click="saveEditRooms(modalSection)">
                                    Сохранить изменения
                                </button>
                            </slot>
                        </div>
                    </template>
                    <template v-else-if="modalIndex === 2">
                        <div class="modal-header">
                            <slot name="header">
                                @{{ sections[modalSection].name }}
                            </slot>
                            <div class="modal-close" @click="showModal = false"></div>
                        </div>
                        <div class="modal-body">
                            <slot name="body">
                                <div class="modal-inputs" v-for="(newTable,key) in newTables" :key="key">
                                    <div class="modal-input-close" v-if="key !== 0 && newTableStatus" @click="removeTable(key)"></div>
                                    <div class="modal-100">
                                        <div class="modal-input">
                                            <div>Название стола</div>
                                            <input type="text" class="modal-text" ref="newTable" v-model="newTable.title" :disabled="!newSectionsStatus" autocomplete="off">
                                        </div>
                                        <div class="modal-input">
                                            <div>Вместимость (кол.человек)</div>
                                            <input type="text" class="modal-text" v-model="newTable.limit" :disabled="!newSectionsStatus" v-mask="'#################'">
                                        </div>
                                    </div>
                                    <div class="modal-100">
                                        <div class="modal-input">
                                            <div>Цена</div>
                                            <input type="text" class="modal-text" v-model="newTable.price" :disabled="!newSectionsStatus" v-mask="'#################'">
                                        </div>
                                        <div class="modal-input">
                                            <div>Статус</div>
                                            <select class="modal-select" v-model="newTable.status" :disabled="!newTableStatus">
                                                <option value="ENABLED" :selected="newTable.status === 'ENABLED'">Включен</option>
                                                <option value="FROZEN" :selected="newTable.status === 'FROZEN'">Отключен</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </slot>
                        </div>
                        <div class="modal-footer">
                            <slot name="footer">
                                <button class="modal-additional-button" v-if="newTableStatus" @click="addTable()">
                                    Добавить стол
                                </button>
                                <button class="modal-default-button" @click="saveTables()">
                                    Готово
                                </button>
                            </slot>
                        </div>
                    </template>
                    <template v-else-if="modalIndex === 3">
                        <div class="modal-header">
                            <slot name="header">
                                @{{ sections[modalSection].name }}
                            </slot>
                            <div class="modal-close" @click="showModal = false"></div>
                        </div>
                        <div class="modal-body">
                            <slot name="body">
                                <div class="modal-inputs">
                                    <div class="modal-100">
                                        <div class="modal-input">
                                            <div>Название стола</div>
                                            <input type="text" class="modal-text" ref="editTable" v-model="sections[modalSection].organization_tables[modalTable].title" :disabled="!newSectionsStatus" autocomplete="off">
                                        </div>
                                        <div class="modal-input">
                                            <div>Вместимость (кол.человек)</div>
                                            <input type="text" class="modal-text" v-model="sections[modalSection].organization_tables[modalTable].limit" :disabled="!newSectionsStatus" v-mask="'#################'">
                                        </div>
                                    </div>
                                    <div class="modal-100">
                                        <div class="modal-input">
                                            <div>Цена</div>
                                            <input type="text" class="modal-text" v-model="sections[modalSection].organization_tables[modalTable].price" :disabled="!newSectionsStatus" v-mask="'#################'">
                                        </div>
                                        <div class="modal-input">
                                            <div>Статус</div>
                                            <select class="modal-select" v-model="sections[modalSection].organization_tables[modalTable].status" :disabled="!newTableStatus">
                                                <option value="ENABLED" :selected="sections[modalSection].organization_tables[modalTable].status === 'ENABLED'">Включен</option>
                                                <option value="FROZEN" :selected="sections[modalSection].organization_tables[modalTable].status === 'FROZEN'">Отключен</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </slot>
                        </div>
                        <div class="modal-footer">
                            <slot name="footer">
                                <button class="modal-default-button" @click="saveEditTable()">
                                    Готово
                                </button>
                            </slot>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </transition>
</template>
