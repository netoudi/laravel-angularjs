angular.module('app.filters')
    .filter('fileExtension', ['$sce', function ($sce) {
        return function (input) {
            var icon;

            switch (input) {
                case 'xls':
                case 'xlsx':
                    icon = '<i class="fa fa-file-excel-o"></i>';
                    break;
                case 'pdf':
                    icon = '<i class="fa fa-file-pdf-o"></i>';
                    break;
                case 'doc':
                case 'docx':
                    icon = '<i class="fa fa-file-word-o"></i>';
                    break;
                case 'zip':
                case 'rar':
                    icon = '<i class="fa fa-file-archive-o"></i>';
                    break;
                case 'gif':
                case 'png':
                case 'jpg':
                case 'jpeg':
                    icon = '<i class="fa fa-file-image-o"></i>';
                    break;
                case 'mp3':
                case 'avi':
                    icon = '<i class="fa fa-file-audio-o"></i>';
                    break;
                case 'mp4':
                case 'mkv':
                    icon = '<i class="fa fa-file-video-o"></i>';
                    break;
                case 'txt':
                    icon = '<i class="fa fa-file-text-o"></i>';
                    break;
                case 'php':
                case 'html':
                case 'js':
                    icon = '<i class="fa fa-file-code-o"></i>';
                    break;
                case 'ppt':
                case 'pptx':
                case 'pps':
                    icon = '<i class="fa fa-file-powerpoint-o"></i>';
                    break;
                default:
                    icon = '<i class="fa fa-file-o"></i>';
                    break;
            }

            return $sce.trustAsHtml(icon);
        };
    }]);
