# mak

とりあえず途中遊び程度。
途中なので説明が中途半端なので適当に感じて下さい。

archive.html
author.html
page.html
single.html

タグ
ID : {{mak_post_id()}}
Permalink : {{mak_permalink()}}
Title : {{mak_title()}}
Author ID : {{mak_author_id()}}
Author Avatar : {{mak_author_avatar()}}
Author Description : {{mak_author_description()}}
Author Name : {{mak_author_name()}}
Post Date : {{mak_post_date()}}
デフォルトは yyyy/MM/dd
変更する場合は {{mak_post_date()|data:'yyyy年MM月dd日'}}
Thumbnail View : {{mak_thumbnail().view}}
has_thumbnail みたいなの
例:

```html:archive.html
	<p class="thumbnail" ng-if="mak_thumbnail().view">
		<a ng-href="{{mak_permalink()}}">
			<img class="thumbnail-{{mak_thumbnail().id}}" ng-src="{{mak_thumbnail().url}}" width="{{mak_thumbnail().width}" height="{{mak_thumbnail().height}}" alt="{{mak_thumbnail().title}}">
		</a>
	</p>
```

Thumbnail ID : {{mak_thumbnail().id}}
Thumbnail Height : {{mak_thumbnail().height}}
Thumbnail URL : {{mak_thumbnail().url}}
Thumbnail Width : {{mak_thumbnail().width}}
Thumbnail Title : {{mak_thumbnail().title}}
※サイズを変更する場合は
各 mak_thumbnail() を mak_thumbnail('large') 等にする。

カテゴリー
```html:archive.html
<p class="category" ng-if="!!mak_terms()" ng-repeat="term in mak_terms()">
Term Name:{{term.name}}<br>
Term ID:{{term.ID}}<br>
Term Slug:{{term.slug}}<br>
Term Description:{{term.description}}<br>
Term Parent:{{term.parent}}<br>
Term Count:{{term.count}}<br>
Term Link:{{term.link}}<br>
</p>
```
※タグを表示したい場合は
```
<p class="tag" ng-if="!!mak_terms('post_tag')" ng-repeat="term in mak_terms('post_tag')">
```
のように mak_terms('post_tag') を入れる。
post_tag ではなくカスタムタクソノミーを指定できると思います。

基本、/archives/%post_id% のパーマリンク。


デモ
http://webnist.github.io/
S3 に上げても出来ます。

これからの課題
- もう少し、見た目を整える。
- 投稿内のリンク先の変更。
- 機能拡張(プラグイン的な)的な事を考える。

