# cot_fileAPI
Модуль загрузки файлов для Cotonti

Модуль на стадии разработки, но можно уже побаловаться...
но описание и возможности будут расширятся..
-------

в файл page.add.tpl вставляем вызов формы: 
```html
<!-- IF {PHP|cot_module_active('fileAPI')} -->	
  {PHP|fileAPI_prepare('page')}
  {PHP.cfg.fileAPI.prepare|fileAPI_form('$this,dnd:1')} 
<!-- ENDIF -->
```
в файл page.edit.tpl вставляем..
```html
<!-- IF {PHP|cot_module_active('fileAPI')} -->
  {PHP|fileAPI_form('area:page,cat:$pag.page_cat,indf:$id,dnd:1')} 
<!-- ENDIF -->	
```
параметр dnd:1 - загрузка с поддержкой Drag&Drop. dnd:0 - без поддержки..
для вывода прикрепленных файлов к странице вставляем в page.tpl
вывод всех файлов
```html
<!-- IF {PHP|cot_module_active('fileAPI')} -->
  {PHP|fileAPI_files('area:page, cat:$c, indf:$id, type:all' ,'thumb')} 
<!-- ENDIF -->
```
вывод изображений
```html
<!-- IF {PHP|cot_module_active('fileAPI')} -->
  {PHP|fileAPI_files('area:page, cat:$c, indf:$id, type:image' ,'thumb')} 
<!-- ENDIF -->
```
вывод файлов
```html
<!-- IF {PHP|cot_module_active('fileAPI')} -->
  {PHP|fileAPI_files('area:page, cat:$c, indf:$id, type:file' ,'thumb')} 
<!-- ENDIF -->
```

Вывод файлов к страницам в списке страниц.
Добавляем в файл page.list.tpl:

````html
<!-- IF {PHP|cot_module_active('fileAPI')} -->
  {LIST_ROW_ID|fileAPI_files('loop:1, area:page, indf:$this, type:all','thumb')} 
<!-- ENDIF -->
````
в блок <!-- BEGIN: LIST_ROW --> ... <!-- END: LIST_ROW -->
параметр loop:1 указывает на режим с минимальным кол. запросов к базе. Если не поставить значение в 1, то каждый вывод к странице будет тянуть 1 обращение к базе MySQL
Следите за обновлениями, будет много вкусного ;)
