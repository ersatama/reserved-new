<template>
    <div class="container-fluid">
        <div class="container p-0">
            <div class="search-layout">
                <div class="search-layout-text">
                    <div class="search-layout-text-icon"></div>
                    <input type="text" class="search-layout-text-input" placeholder="Поиск">
                </div>
            </div>
            <div class="search-tags">
                <div class="search-tag">Hello world</div>
                <div class="search-tag">Hello world</div>
                <div class="search-tag">Hello world</div>
                <div class="search-tag">Hello world</div>
                <div class="search-tag">Hello world</div>
                <div class="search-tag">Hello world</div>
                <div class="search-tag">Hello world</div>
                <div class="search-tag">Hello world</div>
                <div class="search-tag">Hello world</div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Search"
}
</script>

<style lang="scss">
    .search {
        &-layout {
            width: 500px;
            height: auto;
            background: #fff;
            margin: 20px auto 0 auto;
            border: 1px solid #e6f1ec;
            border-radius: 35px;
            overflow: hidden;
            &-text {
                margin: 10px;
                position: relative;
                &-icon {
                    width: 16px;
                    height: 16px;
                    background: url(/img/logo/search.png) no-repeat center;
                    background-size: contain;
                    position: absolute;
                    top: 50%;
                    left: 15px;
                    transform: translate(0,-50%);
                }
                &-input {
                    border: none;
                    width: 100%;
                    padding: 10px 15px 10px 45px;
                    border-radius: 25px;
                    outline: none !important;
                    background: #e6f1ec;
                    font-size: 14px;
                }
            }
        }
        &-tags {
            margin: 20px 0 0 0;
            display: flex;
            gap: 10px;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }
        &-tag {
            padding: 5px 10px 5px 10px;
            background: #57a283;
            color: #fff;
            border-radius: 40px;
        }
    }
</style>
