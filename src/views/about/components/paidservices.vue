<template>
  <div class="flex w-full flex-col flex-nowrap space-y-4">
    <div class="flex w-full flex-row flex-wrap rounded-lg py-5 space-y-4 bg-gray-100 dark:bg-dark-900 p-5">
      <h2>
        Оказание платных образовательных услуг
      </h2>
      <p>
        Школа может осуществлять, по согласованию с Учредителем, предоставление
        платных образовательных услуг, на основании Положения о платных
        образовательных услугах. Платные образовательные услуги не могут быть
        оказаны вместо образовательной деятельности, финансируемой за счет
        субсидии на выполнение муниципального задания. Обучение в классах на
        платной основе осуществляется по общеразвивающей программе
        "Изобразительное искусство". Правом поступления в ДХШ на обучение в
        классах на платной основе со сроком обучения 2 года обладают дети в
        возрасте 9-10 лет и со сроком обучения 1 год - в возрасте 10 лет, при
        условии наличия свободных мест. Правом поступления в ДХШ, с целью
        поступления в СУЗы, ВУЗы, со сроком обучения 1 год обладают все желающие
        лица в возрасте от 15 лет, при условии наличия свободных мест.
      </p>
    </div>
    <tabs category="Платные образовательные услуги" />
    <div
      class="
        flex
        max-w-7xl
        w-full
        flex-col flex-nowrap
        space-y-4
        p-5
        bg-gray-100
        dark:bg-dark-900
        overflow-x-auto
        relative
      "
    >
      <h2 class="ml-4 mb-10 text-2xl font-semibold">
        Расписание занятий по платным классам
      </h2>
      <div class="table w-full overflow-x-auto sticky top-16">
        <div class="table-header-group">
          <div class="table-row">
            <div class="table-cell font-bold">Группа</div>
            <div class="table-cell font-bold">Время</div>
            <div class="table-cell font-bold">Преподаватель</div>
            <div class="table-cell font-bold">Каб</div>
            <div class="table-cell font-bold">День</div>
          </div>
        </div>
        <div class="table-row-group">
          <time-table
            v-for="(timetable, index) of timetables"
            :key="index"
            :timetable="timetable"
            class="odd:bg-gray-200 dark:odd:bg-dark-800"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Tabs from "../../../components/documents/tabs.vue";
import TimeTable from "../../../components/table/time-table.vue";

export default {
  data() {
    return {
      timetables: [
        {
          group: "Живопись",
          time: "17:30 - 19:50",
          teacher: "Котелевская О.П",
          cabinet: "-",
          day: "Понедельник",
        },
        {
          group: "Композиция",
          time: "16:40 - 19:00",
          teacher: "Котелевская О.П",
          cabinet: "-",
          day: "Четверг",
        },
        {
          group: "Рисунок",
          time: "16:00 - 17:30",
          teacher: "Телешун Н.В",
          cabinet: "-",
          day: "Пятница",
        },
        {
          group: "1",
          time: "11:50 - 13:10",
          teacher: "Патрушева О.В",
          cabinet: "11",
          day: "Суббота",
        },
        {
          group: "2",
          time: "13:20 - 14:40",
          teacher: "Патрушева О.В",
          cabinet: "11",
          day: "Суббота",
        },
        {
          group: "3",
          time: "14:50 - 16:10",
          teacher: "Патрушева О.В",
          cabinet: "11",
          day: "Суббота",
        },
        {
          group: "4",
          time: "12:00 - 13:20",
          teacher: "Струкова Л.П",
          cabinet: "2",
          day: "Суббота",
        },
        {
          group: "5",
          time: "13:30 - 14:50",
          teacher: "Струкова Л.П",
          cabinet: "2",
          day: "Суббота",
        },
        {
          group: "6",
          time: "15:00 - 15:20",
          teacher: "Струкова Л.П",
          cabinet: "2",
          day: "Суббота",
        },
        {
          group: "7",
          time: "16:30 - 18:00",
          teacher: "Струкова Л.П",
          cabinet: "2",
          day: "Суббота",
        },
      ],
    };
  },
  components: {
    Tabs,
    TimeTable,
  },
  Tabs,
};
</script>

<style>
</style>