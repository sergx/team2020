# team2020

12.07
Добавить в стандарном виде CRUD-модули для:
  ok Материалы на складе
  ok Материалы в резерве
  ok Площадки-партнеры
  ok Продавцы
  ok Агенты

Добавить ссылки на все эти элементы на дашборд


Параметры новой заявки (сделки):
 - Указание материала (возможно (или обязательно), со ссылкой на этот материал в системе)
 - Данные продавца (если материал не из системы) - Имя (компания), место, телефон, прочие данные в комментарии
 - Данные покупателя - Имя (компания), место, телефон, прочие данные в комментарии
 - Способ транспортировки - готовые вариаты или свой вариант (+ комментарий. Можно несколько добавлять)
 - Кто берет на себя обеспечение транспортировки (+ комментарий)
 - Способ оплаты - нал, безнал, отсрочка (+ комментарий)
 - Цена (Если материал есть в системе, то можно вывести цену, за которую он был куплен, чтобы наглядно показать выгоду/целесообразность)
 - Общий комментарий

Сделка может быть одобрена
 - Тогда она принимает соответствующий статус "Сделка одобрена, деньги (будут) выделены"
 - Можно скачать документы, или есть инструкция о том как получить деньги / провести оплату

Если сделка НЕ одобрена.

  Если материала уже по каким-то причинам нет (кто-то другой продал)
   - сделка просто закрывается с соответствующим уведомлением

  Если материал есть, но параметры сделки не устраивают Центральное управление
  - Указывается причина, чтобы Агент ее исправил
    например это могут быть
    - Некоррекно, или неполно заполнены данные
    - Не устраивает цена, или прочие условия/нюансы

  Этот круг запросов может повторяться неогрониченное кол-во раз, и привратиться в консультации и уточнения
  - ? Агент может прокомментировать отказ - попытаться его оспорить, или попросить разъяснения

  Визуально под заявкой отображается история изменений и переписки. По сути эта заявка - это прологнированный тикет (диалог) с формализованными функциями




Чат/тикет-система
 - Разные пользователи могут получать уведомления разного уровня
   - Аналитик, админ, Терпрод получает уведомление от агента и может на него ответить
   - Агент получает ответ на свой запрос от любого, кто может ответить
 - Статус уведомления - "прочитан мной", "прочитан кем-то", "не прочитан"
 - ? список прочитавших уведомление
 - Для того, кто отправил уведомление - отображать прочитал ли получатель
 - ? -//- но не всегда - например Админ/т.п. видят - прочитал ли Агент. А Агенту может и не обязательно видеть - прочитал ли Админ/т.п., важно просто ответ получить
 - Уведомления могут быть помечены как прочитанное или непрочитанное вручную
 - Уведомления могут дублироваться на почту/в телеграм
 - ? Из телеграма можно что-то ответить - как-то отреагировать на сообщение, например подтвердить цену, или наоборот отклонить. Ну или по крайней мере - иметь прямую ссылку для входа в панель управления для ускорения ответа


notification Module

 - связь с автором (юзером)
 - связь с элементом-модулем (матреиал/сделка/...)
 - данные-атрибуты события
 - ? шаблонные действия
 - статус о прочтении - "прочитан мной", "прочитан кем-то", "не прочитан" (? список прочитавших уведомление)
 - статус о прочтении хранится в отдельной таблице notification_views
 - Deal Log = Уведомления, убрать как рудимент
