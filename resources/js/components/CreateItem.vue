<template>
	<div>
        <div class="d-flex flex-column justify-content-center justify-content-sm-start mt-3">
	        <a-select
	        v-model="selectedCategory"
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
            <div class="d-flex flex-column flex-sm-row ">
            	
            	<div class="d-flex flex-column">
            	<label :class="['img-container', {'empty-field': imgValid}]">
                	<input
                	id='imgselector'
                	type="file"
                	name="img"
                	@change="imgChanged"
                	>
                    <img v-if="selectedImg" :src="selectedImg">
                    <div class="d-flex justify-content-center align-items-center" v-else>Выберите изображение</div>
                </label>
            	</div>
                <div class="d-inline-flex flex-column align-items-start ml-sm-5">
                	<a-input
                	v-model="name"
                	id="item-name"
                	:class="['mb-2', {'empty-field': nameValid}]"
                	placeholder="Наименование"
                	@input="nameValid=false"
                	></a-input>
            		<a-input
            		v-model="price"
            		:class="[{'empty-field': priceValid}]"
            		placeholder="Цена, руб."
            		class="mb-5"
            		id="item-price"
            		@keydown="filterInput"
            		></a-input>
                    <label>
                		<div>Количесво</div>
                		<counter @counter="updateCount"></counter>
                	</label>
                </div>
            </div>
        </div>
        <h1 class="mt-5">
            Описание товара
        </h1>
        <div class="item-desc-content">
            <a-textarea v-model="desc" placeholder="Описание товара" :rows="4"/>
        </div>
        <div class="apply-cancel-buttons">
	        <a-button @click="apply">
	        	Сохранить
	        </a-button>
    	</div>
    </div>
</template>
<script type="text/javascript">
	export default {
		components: {
            'counter': require('./Counter.vue').default,
        },
		data() {
			return {
				selectedCategory: this.$store.state.categoryFilter ?
					+this.$store.state.categoryFilter : undefined,
				selectedImg: null,
				selectedImgRaw: null,
				itemAmount: 1,
				name: null,
				price: null,
				desc: '',

				categoryValid: false,
				imgValid: false,
				nameValid: false,
				priceValid: false,
			}
		},
		methods: {
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
			imgChanged (img) {
				if (imgselector.files[0]){
					this.imgValid = false
					this.selectedImg = URL.createObjectURL(imgselector.files[0])
					this.selectedImgRaw = imgselector.files[0]
				}
				
			},
			updateCount (count) {
				this.itemAmount = count;
			},
			apply() {
				if (!this.selectedCategory) this.categoryValid = true
				if (!this.name) this.nameValid = true
				if (!this.selectedImg) this.imgValid = true
				if (!this.price) this.priceValid = true
				if (this.categoryValid || this.nameValid
					|| this.imgValid || this.priceValid) {
					this.$message.warning('Чтобы продолжить заполните все поля!');
					return
				}

				const hide = this.$message.loading('Загрузка...', 0)

				var formData = new FormData()
				formData.append("name", this.name)
				formData.append("price", this.price)
				formData.append("category", this.selectedCategory)
				formData.append("amount", this.itemAmount)
				formData.append("image", this.selectedImgRaw)
				formData.append("desc", this.desc)

				var xhr = new XMLHttpRequest()
                xhr.open ('post', '/createitem', true)
                xhr.setRequestHeader('X-XSRF-TOKEN', getCookie('XSRF-TOKEN'))
                xhr.send (formData)
                xhr.onreadystatechange = () => {
                if (xhr.readyState === 4
                    && xhr.responseText) {
	                	hide()
	                	this.$message.success('Товар добавлен!', 0.5)
	                	.then(()=> this.cancel())
                    }
                }
			},
			cancel() {
				window.location = '/' + ((this.$store.state.categoryFilter) ?
                '?category=' + this.$store.state.categoryFilter : '')
			}
		}
	}
</script>

<style type="text/css">
	.category-select {
		width: 200px;
	}
	.img-container {
		width: 350px;
	}

	.img-container img {
		max-height: 500px;
        width: 100%;
        object-fit: contain;
	}
	.img-container div {
		height: 200px;
        width: 100%;
		border-color: #bbb;
        border-radius: 3px;
        border-style: dashed;
        border-width: 1px;

        font-size: 17px;
        font-style: italic;
	}
	.img-container img:hover {
		border-color: #999;
	}
	.img-container input {
		display: none;
	}
	.apply-cancel-buttons {
		position: fixed;
		right: 15px;
		bottom: 15px;
	}
	#item-price {
		width: 100px;
	}
	#item-name {
		max-width: 300px;
	}
	.empty-field {
		border-color: red !important;
		box-shadow: 0 0 5px 3px rgba(200, 0, 0, 0.2) !important;
	}
	.empty-field div {
		border-color: red !important;
	}
</style>