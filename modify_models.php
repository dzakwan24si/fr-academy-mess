<?php
$dir = __DIR__ . '/app/Models';
$files = scandir($dir);
foreach ($files as $file) {
    if (in_array($file, ['.', '..'])) continue;
    
    $path = $dir . '/' . $file;
    $content = file_get_contents($path);
    
    if ($file === 'User.php') {
        // Add HasRoles trait
        if (strpos($content, 'use Spatie\Permission\Traits\HasRoles;') === false) {
            $content = str_replace('use Illuminate\Notifications\Notifiable;', "use Illuminate\Notifications\Notifiable;\nuse Spatie\Permission\Traits\HasRoles;\nuse Illuminate\Database\Eloquent\SoftDeletes;", $content);
            $content = str_replace('use HasFactory, Notifiable;', "use HasFactory, Notifiable, HasRoles, SoftDeletes;", $content);
        }
    } else {
        // Add SoftDeletes
        if (strpos($content, 'use Illuminate\Database\Eloquent\SoftDeletes;') === false) {
            $content = str_replace('use Illuminate\Database\Eloquent\Model;', "use Illuminate\Database\Eloquent\Model;\nuse Illuminate\Database\Eloquent\SoftDeletes;", $content);
        }
        
        // Add SoftDeletes trait and guarded property
        if (strpos($content, 'use SoftDeletes;') === false) {
            $content = preg_replace('/class (\w+) extends Model\n\{/', "class $1 extends Model\n{\n    use SoftDeletes;\n\n    protected \$guarded = [];", $content);
        }
    }
    
    file_put_contents($path, $content);
    echo "Modified $file\n";
}
