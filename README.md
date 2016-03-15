# cot_fileAPI
Модуль загрузки файлов для Cotonti

Модуль на стадии разработки, но можно уже побаловаться...
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

Следите за обновлениями, будет много вкусного ;)
