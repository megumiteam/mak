# mak

# May not be available in future versions of WP REST API.

for now the explanations are midway, since this work is still in progress.

- archive.html
- author.html
- page.html
- single.html

## Tag
- ID : {{mak_post_id()}}
- Permalink : {{mak_permalink()}}
- Title : {{mak_title()}}
- Author ID : {{mak_author_id()}}
- Author Avatar : {{mak_author_avatar()}}
- Author Description : {{mak_author_description()}}
- Author Name : {{mak_author_name()}}
- Post Date : {{mak_post_date()}}
- the default format: yyyy/MM/dd
- if you want to change, format like: {{mak_post_date()|data:'yyyy年MM月dd日'}}
- Thumbnail View : {{mak_thumbnail().view}}
- something like has_thumbnail

Example:

```html:archive.html
	<p class="thumbnail" ng-if="mak_thumbnail().view">
		<a ng-href="{{mak_permalink()}}">
			<img class="thumbnail-{{mak_thumbnail().id}}" ng-src="{{mak_thumbnail().url}}" width="{{mak_thumbnail().width}" height="{{mak_thumbnail().height}}" alt="{{mak_thumbnail().title}}">
		</a>
	</p>
```

- Thumbnail ID : {{mak_thumbnail().id}}
- Thumbnail Height : {{mak_thumbnail().height}}
- Thumbnail URL : {{mak_thumbnail().url}}
- Thumbnail Width : {{mak_thumbnail().width}}
- Thumbnail Title : {{mak_thumbnail().title}}

※if you want to change each size of mak_thumbnail() to mak_thumbnail('large')

** Category

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

※If you want to display a tag, please see below:

```
<p class="tag" ng-if="!!mak_terms('post_tag')" ng-repeat="term in mak_terms('post_tag')">
```

Write like mak_terms('post_tag'). I think you can put a custom taxonomy too.

Basically, the permalink format is:
/archives/%post_id%


Demo:

http://demo1.web-purine.com/

You can put it on S3.

Future tasks:

- Improve the appearance.
- Change links in a post.
- Function extension (like plugin feature).
