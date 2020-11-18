<template>
    <div>
        <div class="d-flex flex-column justify-content-center justify-content-sm-start mt-3">
            <a-select
            v-if="$store.state.isAdmin"
            v-model="newSelectedCategory"
            :class="['mb-3', 'category-select', {'empty-field':categoryValid}]"
            placeholder="Категория"
            style="border-color: red;"
            @change="categoryValid=false"
            notFoundContent="Категорий не найдено"
            >
                <template v-for="category in $store.state.categories">
                    <a-select-option
                    :key="category.id"
                    >{{category.name}}
                    </a-select-option>
                </template>
            </a-select>
            <a class="mb-3" v-else :href="category_url(category_id)">{{category_name}}</a>
            <div class="d-flex flex-column flex-sm-row ">
                <div class="d-flex flex-column">
                    <label
                    v-if="$store.state.isAdmin"
                    :class="['img-container', {'empty-field': imgValid}]"
                    >
                        <input
                        id='imgselector'
                        type="file"
                        name="img"
                        @change="imgChanged"
                        >
                        <img class="item-img" v-if="newSelectedImg" :src="newSelectedImg">
                        <div class="d-flex justify-content-center align-items-center" v-else>Выберите изображение</div>
                    </label>
                    <img v-else class="align-self-start item-img" :src="'/img/' + img">
                </div>
                <div class="d-inline-flex flex-column align-items-start ml-sm-5">
                    <a-input
                    v-if="$store.state.isAdmin"
                    v-model="newName"
                    id="item-name"
                    :class="['my-3', {'empty-field': nameValid}]"
                    placeholder="Наименование"
                    @input="nameValid=false"
                    ></a-input>
                    <h1 style="word-break: break-word;" class="my-3" v-else>
                        {{name}}
                    </h1>
                    <a-input
                    v-if="$store.state.isAdmin"
                    v-model="newPrice"
                    :class="[{'empty-field': priceValid}]"
                    placeholder="Цена, руб."
                    class="mb-5"
                    id="item-price"
                    @keydown="filterInput"
                    ></a-input>
                    <div v-else class="text-danger font-weight-bold item-price mt-3">
                        {{price}} &#8381;
                    </div>
                    <label v-if="$store.state.isAdmin">
                        <div>Количесво</div>
                        <counter
                        :value="newItemAmount"
                        @counter="updateAmount"
                        ></counter>
                    </label>
                    <counter v-else :max=amount @counter="updateCount" class="mt-auto"></counter>
                    <bue-button v-if="!$store.state.isAdmin" :count="count" :item_id="item_id" class="mt-2 mb-5 w-75"></bue-button>
                </div>
            </div>
        </div>
        <h1 class="mt-5">
            Описание товара
        </h1>
        <div v-if="$store.state.isAdmin" class="item-desc-content">
            <a-textarea v-model="newDesc" placeholder="Описание товара" :rows="4"/>
        </div>
        <div v-else class="item-desc-content">
            {{desc}}
        </div>
        <div v-if="$store.state.isAdmin" class="apply-cancel-buttons">
            <a-button @click="apply">
                Сохранить
            </a-button>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                count: 1,

                newSelectedCategory: +this.category_id,
                newSelectedImg: '/img/' + this.img,
                newSelectedImgRaw: null,
                newItemAmount: this.amount,
                newName: this.name,
                newPrice: this.price,
                newDesc: this.desc,

                categoryValid: false,
                imgValid: false,
                nameValid: false,
                priceValid: false,
            }
        },
        props: {
            item_id: {
                default: 0
            },
            category_id: {
                default: 0
            },
            category_name: {
                default: ''
            },
            name: {
                default: ''
            },
            price: {
                default: 0
            },
            desc: {
                default: ''
            },
            img: {
                default: ''
            },
            amount: {
                default: 0
            },
        },
        components: {
            'bue-button': require('./BueButton.vue').default,
            'counter': require('./Counter.vue').default,
        },
        methods:{
            category_url(category_id)
            {
                return '/' + '?category='+ category_id;
            },
            updateCount(count){
                this.count = count;
            },
            filterInput(e){
                if (e.key.match(/[^0-9]/)
                    && e.key !== 'Backspace'
                    && e.key !== 'ArrowLeft'
                    && e.key !== 'ArrowRight'
                    && e.key !== 'Delete'
                ) {
                    e.preventDefault()
                    return
                }
                this.priceValid = false
            },
            imgChanged(img) {
                if (imgselector.files[0]){
                    this.imgValid = false
                    this.newSelectedImg = URL.createObjectURL(imgselector.files[0])
                    this.newSelectedImgRaw = imgselector.files[0]
                }
                
            },
            updateAmount(count) {
                this.newItemAmount = count;
            },
            apply() {
                if (!this.newSelectedCategory) this.categoryValid = true
                if (!this.newName) this.nameValid = true
                if (!this.newSelectedImg) this.imgValid = true
                if (!this.newPrice) this.priceValid = true
                if (this.categoryValid || this.nameValid
                    || this.imgValid || this.priceValid) {
                    this.$message.warning('Чтобы продолжить заполните все поля!');
                    return
                }

                const hide = this.$message.loading('Загрузка...', 0)

                var formData = new FormData()
                formData.append("name", this.newName)
                formData.append("price", this.newPrice)
                formData.append("category", this.newSelectedCategory)
                formData.append("amount", this.newItemAmount)
                formData.append("image", this.newSelectedImgRaw)
                formData.append("desc", this.newDesc)

                var xhr = new XMLHttpRequest()
                xhr.open ('post', '/updateitem/' + this.item_id, true)
                xhr.setRequestHeader('X-XSRF-TOKEN', getCookie('XSRF-TOKEN'))
                xhr.send (formData)
                xhr.onreadystatechange = () => {
                if (xhr.readyState === 4
                    && xhr.responseText) {
                        hide()
                        this.$message.success('Товар обновлен!', 0.5)
                    }
                }
            },
            cancel() {
                window.location = '/' + ((this.$store.state.categoryFilter) ?
                '?category=' + this.$store.state.categoryFilter : '')
            }
        },
    }
</script>

<style scoped>

    .item-price {
        font-size: 35px;
        font-weight: bold;
        color: red;
    }
    .item-desc-content {
        font-size: 14px;
        word-break: break-word;
    }
    .item-img {
        max-height: 500px;
        max-width: 100%;
        flex-shrink: 0
    }
</style>