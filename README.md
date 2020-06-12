# EleDocs
Use Elementor Pro to visually design WeDocs frontend.
Create global template for Doc, Section & Atricles.
Use 6 Elementor widgets to design you documentation layout.
On-Page search.

## Elementor Widget
* Article Sidebar.
* Breadcrumbs.
* Docs - Grid view of docs & sections.
* Search Doc - Doc search form.
* Sections - Grid view of sections & articles.
* Children - Section articles.

## Elementor Dynamic Tag
* Doc Title - Display doc title inside single doc, section & article page.


## Dependency
* WeDocs
* Elementor Pro


## Vocabulary
This plugin takes the root level docs post as DOC, direct children of DOC as
SECTION & anything under SECTION as ARTICLE.


## Creating a template for Single Doc page
1. Create a elementor template from Templates > Theme Builder > Single > Add new.
2. Select Post type as `Doc`, give it a name.
3. Place your desired elements (widgets) on the template & style it.
4. Click on `Display Condition` and select include location as `Doc` & save it.

## Creating a template for Doc Section page
1. Create a elementor template from Templates > Theme Builder > Single > Add new.
2. Select Post type as `Doc`, give it a name.
3. Place your desired elements (widgets) on the template & style it.
4. Click on `Display Condition` and select include location as `Section` & save it.

## Creating a template for Articles page
1. Create a elementor template from Templates > Theme Builder > Single > Add new.
2. Select Post type as `Doc`, give it a name.
3. Place your desired elements (widgets) on the template & style it.
4. Click on `Display Condition` and select include location as `Docs` & save it.
