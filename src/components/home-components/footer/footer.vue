<template>
  <div
    class="
      flex
      justify-center
      flex-col
      items-center
      w-full
      h-full
   mt-10
    "
  >
    <div class="flex max-w-7xl w-full h-max flex-col flex-nowrap rounded-lg">
      <div class="flex flex-col flex-nowrap p-5 border-b border-gray-300">
        <div
          class="flex flex-row justify-between items-center flex-wrap w-full"
        >
          <router-link to="/" class="w-max mb-5"
            ><img src="@/assets/logodefault.svg" class="w-32 h-20" alt=""
          /></router-link>
          <div class="flex flex-row flex-wrap justify-start items-center">
            <router-link
              class="
                cursor-pointer
                border border-gray-200
                py-2
                px-5
                w-max
                h-max
                flex
                justify-center
                items-center
                rounded-full
                mb-2
                mr-2
              "
              to="/posts"
              >Блог</router-link
            >
            <router-link
              class="
                cursor-pointer
                border border-gray-200
                py-2
                px-5
                w-max
                h-max
                flex
                justify-center
                items-center
                rounded-full
                mb-2
                mr-2
              "
              to="/cources"
              >Курсы</router-link
            >
            <router-link
              class="
                cursor-pointer
                border border-gray-200
                py-2
                px-5
                w-max
                h-max
                flex
                justify-center
                items-center
                rounded-full
                mb-2
                mr-2
              "
              to="/parrent"
              >Родителям</router-link
            >
            <router-link
              class="
                cursor-pointer
                border border-gray-200
                py-2
                px-5
                w-max
                h-max
                flex
                justify-center
                items-center
                rounded-full
                mb-2
                mr-2
              "
              to="/cources"
              >Учащимся</router-link
            >
            <router-link
              class="
                cursor-pointer
                border border-gray-200
                py-2
                px-5
                w-max
                h-max
                flex
                justify-center
                items-center
                rounded-full
                mb-2
                mr-2
              "
              to="/documents"
              >Документы</router-link
            >
            <router-link
              class="
                cursor-pointer
                border border-gray-200
                py-2
                px-5
                w-max
                h-max
                flex
                justify-center
                items-center
                rounded-full
                mb-2
                mr-2
              "
              to="/about"
              >О нас</router-link
            >
          </div>
        </div>
      </div>

      <div
        class="
          flex flex-col
          md:flex-row
          flex-wrap
          md:flex-nowrap
          w-full
          h-max
          p-5
          justify-between
          items-start
        "
      >
        <div class="flex flex-col w-full md:w-1/3 mr-5 mb-5">
          <h3 class="font-bold mb-5">Контакты</h3>
          <ul class="m-0">
            <li class="list-none text-sm">
              Адрес: 663600 Красноярский край, г. Канск, ул. Московская, дом 64
            </li>
            <li class="list-none text-sm">
              Тел/Факс: (39161) 3-57-53; 3-31-04
            </li>
            <li class="list-none text-sm">Почта: hudoz_kansk@mail.ru</li>
          </ul>
        </div>
        <div class="flex flex-col w-1/3 flex-nowrap mr-5 mb-5">
          <h3 class="font-bold mb-5">Вопросы</h3>
          <button>Обратиться</button>
        </div>
        <div class="flex w-1/3 flex-col flex-nowrap">
          <h3 class="font-bold mb-5">При поддержки</h3>
          <div class="flex flex-row w-full">
            <div class="flex w-full flex-col flex-nowrap mr-2">
              <div
                :style="{
                  'background-image':
                    'url(' + require('@/assets/admin.jpg') + ')',
                  backgroundSize: 'cover',
                }"
                class="flex h-16 rounded-lg w-full"
              ></div>
              <a class="mt-2" href="http://kansk-adm.ru">http://kansk-adm.ru</a>
            </div>
            <div class="flex w-full flex-col flex-nowrap">
              <div
                :style="{
                  'background-image':
                    'url(' + require('@/assets/culture.jpg') + ')',
                  backgroundSize: 'cover',
                }"
                class="flex h-16 rounded-lg w-full"
              ></div>
              <a class="mt-2" href="https://pro.culture.ru"
                >https://pro.culture.ru</a
              >
            </div>
          </div>
        </div>
      </div>
      <div
        class="flex w-full flex-col flex-nowrap justify-center items-center p-2"
      >
        <p class="text-center text-gray-300 w-1/2 text-sm">
          © 2014-2022 Муниципальное бюджетное учреждение дополнительного
          образования Детская художественная школа (МБУДО ДХШ)
        </p>
        <span class="text-blue-500 mt-2 cursor-pointer"
          ><i class="fa-solid fa-code mr-2"></i>and
          <i class="fa-solid fa-circle-half-stroke mr-2">design</i>by toppadeep
        </span>
      </div>
    </div>
  </div>
</template>

<script>
export default {};
</script>
 