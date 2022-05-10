<template>
  <div
    class="
      flex
      w-full
      justify-center
      items-center
      flex-col flex-wrap
    "
  >
    <Accordion-item v-for="faq of faqItems" :key="faq.id" :faqItems="faq" />
  </div>
</template>

<script>
import AccordionItem from "../accordion-components/accordion-item.vue";
export default {
  components: {
    AccordionItem,
  },
  data() {
    return {
      faqItems: [
        {
          id: 1,
          question: "Как подать заявление?",
          answer:
            "Заявление можно подать <a href='https://webdevblog.ru/autentifikacii-v-vue-s-ispolzovaniem-vuex/'>Образец</a> By default, the outer div is display: block, but by adding the md:flex utility, it becomes display: flex on medium screens and larger.",
        },
        {
          id: 2,
          question: "Какой курс лучше выбрать?",
          answer:
            "Карандаши, краски, кисточки, бумагу, баночки для воды, ластик, кнопки",
        },
        {
          id: 3,
          question: "Сколько длится обучение?",
          answer:
            "У нас множество различных курсов с разным сроком обучения, о сроках и порядке обучения можете ознакомиться на странице <a style='color: var(--main-color); font-size: 16px' href='http://localhost:8080/cources'>Курсы</a>",
        },
        {
          id: 4,
          question: "Как до вас добраться?",
          answer:
            "Наша школа находится по адресу: Канск, улица Ленина, 4/1. Вы можете перейти на <a style='color: var(--main-color); font-size: 16px' href='http://localhost:8080/about/#map'>страницу</a> где есть карта и простроить маршрут",
        },
        {
          id: 5,
          question: "Какие материалы купить рёбенку?",
          answer:
            "Карандаши, краски, кисточки, бумагу, баночки для воды, ластик, кнопки",
        },
      ],
    };
  },
};
</script>
