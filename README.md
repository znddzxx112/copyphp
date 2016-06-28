copyphp
================================
文件批量拷贝

usage
---------------
root_path 拷贝根目录<br/>
list.txt 需要拷贝的文件名称<br/>
dest_dir 拷贝到指定目录<br/>
```
require_once 'copyphp.php';
$cp = Copyphp::load(array('_root_path'=>'root_path'));
$cp->copy('list.txt','./dest_dir/');
```
