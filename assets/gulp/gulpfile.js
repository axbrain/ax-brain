const {
    src,
    dest,
    watch,
    series,
    parallel
} = require("gulp");

// sass
const sass = require('gulp-sass')(require('sass'));
sass.compiler = require('sass');

//エラーが発生しても強制終了させない
const plumber = require("gulp-plumber");
//エラー発生時のアラート出力
const notify = require("gulp-notify");
//PostCSS利用
const postcss = require("gulp-postcss");
//プロパティ順をソート
const cssdeclsort = require("css-declaration-sorter");
//sassのimport文を省略する
const sassGlob = require("gulp-sass-glob-use-forward");
//画像圧縮のためのプラグイン
const imagemin = require("gulp-imagemin");
//JPEG圧縮
const imageminMozjpeg = require("imagemin-mozjpeg");
//PNG圧縮
const imageminPngquant = require("imagemin-pngquant");
//SVG圧縮
const imageminSvgo = require("imagemin-svgo");
//自動リロード
const browserSync = require("browser-sync");
// PostCSS plugins
const autoprefixer = require("autoprefixer");
const cssnano = require("cssnano");
const sortMediaQueries = require("postcss-sort-media-queries");

//フォルダ配置先
const path = '../';

//参照元を管理
const srcPath = {
    css: path + "scss/**/*.scss",
    img: path + "src_images/**/*",
}
//参照先を管理
const destPath = {
    css: path + "css",
    img: path + "images"
}

//
//Sassのコンパイル
//
const cssSass = () => {
    return src(srcPath.css, {
            sourcemaps: true
        })
        .pipe(plumber({
            errorHandler: notify.onError(error => {
                console.log(JSON.stringify({
                    title: 'Sass Error',
                    message: error.message
                }, null, 2));
                return {
                    title: 'Sass Error',
                    message: error.message
                };
            })
        }))
        .pipe(sassGlob()) // glob機能を使って@useや@forwardを省略する
        .pipe(sass({
            outputStyle: 'expanded'
        }).on('error', sass.logError))
        .pipe(postcss([
            sortMediaQueries(), // メディアクエリをまとめる
            autoprefixer({
                overrideBrowserslist: [
                    "last 2 versions",
                    "not IE 11",
                    "Android >= 5"
                ]
            }),
            cssnano({
                preset: ['default', {
                    discardComments: {
                        removeAll: true
                    },
                    minifyFontValues: false,
                    normalizeWhitespace: false
                }]
            })
        ]))
        .pipe(dest(destPath.css, {
            sourcemaps: "/"
        })); //CSSとソースマップを出力
}

//
// 画像を圧縮
//
const imgImagemin = () => {
    return src(srcPath.img)
        .pipe(
            imagemin(
                [
                    imageminMozjpeg({
                        quality: 80
                    }),
                    imageminPngquant(),
                    imageminSvgo({
                        plugins: [{
                            name: 'removeViewBox',
                            active: false
                        }]
                    })
                ], {
                    verbose: true
                }
            )
        )
        .pipe(dest(destPath.img))
}

//
//ファイルの自動監視と自動ブラウザリロードの仕組みを作る
//

// //browser-syncの設定
// const browserSyncFunc = () => {
//     browserSync.init(browserSyncOption);
// }

// const browserSyncOption = {
//     proxy: 'https://axbrain.local/', // Local by Flywheelのドメイン
//     open: true,
//     watchOptions: {
//         debounceDelay: 1000
//     },
//     reloadOnRestart: true,
// }

//リロードの処理を作る
const browserSyncReload = (done) => {
    browserSync.reload();
    done();
}

//自動監視の処理を作る
const watchFiles = () => {
    watch(srcPath.css, series(cssSass, browserSyncReload))
    watch(srcPath.img, series(imgImagemin, browserSyncReload))
}

//seriesは順番に実行
//parallelは同時に実行
exports.default = series(series(cssSass, imgImagemin), parallel(watchFiles));