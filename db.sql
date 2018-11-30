drop table if exists category;
create table category
(
    id int unsigned not null auto_increment comment 'ID',
    cat_name varchar(255) not null comment '分类名称',
    parent_id int unsigned not null default 0 comment '上级ID',
    path varchar(255) not null default '-' comment '所有上级分类的ID',
    primary key (id)
)engine=InnoDB comment='分类表';

TRUNCATE category;
INSERT INTO category VALUES
(1,'家用电器',0,'-'),
(2,'电视',1,'-1-'),
(3,'空调',1,'-1-'),
(4,'曲面电视',2,'-1-2-'),
(5,'超薄电视',2,'-1-2-'),
(6,'柜式空调',3,'-1-3-'),
(7,'中央空调',3,'-1-3-'),
(8,'电脑',0,'-'),
(9,'电脑整机',8,'-8-'),
(10,'电脑配件',8,'-8-'),
(11,'笔记本',9,'-8-9-'),
(12,'游戏本',9,'-8-9-'),
(13,'显示器',10,'-8-10-'),
(14,'CPU',10,'-8-10-');


drop table if exists brand;
create table brand
(
    id int unsigned not null auto_increment comment 'ID',
    brand_name varchar(255) not null comment '品牌名称',
    logo varchar(255) not null comment 'LOGO',
    primary key (id)
)engine=InnoDB comment='品牌表';

drop table if exists goods;
create table goods
(
    id int unsigned not null auto_increment comment 'ID',
    goods_name varchar(255) not null comment '商品名称',
    logo varchar(255) not null comment 'LOGO',
    is_on_sale enum('y','n') not null default 'y' comment '是否上架',
    description longtext not null comment '商品描述',
    cat1_id int unsigned not null comment '一级分类ID',
    cat2_id int unsigned not null comment '二级分类ID',
    cat3_id int unsigned not null comment '三级分类ID',
    brand_id int unsigned not null comment '品牌ID',
    created_at datetime not null default current_timestamp comment '添加时间',
    primary key (id)
)engine=InnoDB comment='商品表';

drop table if exists goods_attribute;
create table goods_attribute
(
    id int unsigned not null auto_increment comment 'ID',
    attr_name varchar(255) not null comment '属性名称',
    attr_value varchar(255) not null comment '属性值',
    goods_id int unsigned not null comment '所属的商品ID',
    primary key (id)
)engine=InnoDB comment='商品属性表';

drop table if exists goods_image;
create table goods_image
(
    id int unsigned not null auto_increment comment 'ID',
    goods_id int unsigned not null comment '所属的商品ID',
    path varchar(255) not null comment '图片的路径',
    primary key (id)
)engine=InnoDB comment='商品图片表';

drop table if exists goods_sku;
create table goods_sku
(
    id int unsigned not null auto_increment comment 'ID',
    goods_id int unsigned not null comment '所属的商品ID',
    sku_name varchar(255) not null comment 'SKU名称',
    stock int unsigned not null comment '库存量',
    price decimal(10,2) not null comment '价格',
    primary key (id)
)engine=InnoDB comment='商品SKU表';

drop table if exists privilege;
create table privilege
(
    id int unsigned not null auto_increment comment 'ID',
    pri_name varchar(255) not null comment '权限名称',
    url_path varchar(255) not null comment '对应的URL地址，多个地址用,隔开',
    parent_id int unsigned not null default '0' comment '上级权限的ID',
    primary key (id)
)engine=InnoDB comment='权限表';

drop table if exists role_privlege;
create table role_privlege
(
    pri_id int unsigned not null comment '权限ID',
    role_id int unsigned not null comment '角色ID',
    foreign key role_id references role.id on delete cascade,
    key pri_id(pri_id),
    key role_id(role_id)
)engine=InnoDB comment='角色权限表';

drop table if exists role;
create table role
(
    id int unsigned not null auto_increment comment 'ID',
    role_name varchar(255) not null comment '角色名称',
    primary key (id)
)engine=InnoDB comment='角色表';

drop table if exists admin_role;
create table admin_role
(
    role_id int unsigned not null comment '角色ID',
    admin_id int unsigned not null comment '管理员ID',
    key role_id(role_id),
    key admin_id(admin_id)
)engine=InnoDB comment='管理员角色表';

drop table if exists admin;
create table admin
(
    id int unsigned not null auto_increment comment 'ID',
    username varchar(255) not null comment '用户名',
    password varchar(255) not null comment '密码',
    primary key (id)
)engine=InnoDB comment='管理员表';

insert into privilege(id,pri_name,url_path,parent_id) VALUES
(1,'商品模块','',0),
    (2,'分类列表','category/index',1),
        (3,'添加分类','category/create,category/insert',2),
        (4,'修改分类','category/edit,category/update',2),
        (5,'删除分类','category/delete',2),
    (6,'品牌列表','brand/index',1),
        (7,'添加品牌','brand/create,brand/insert',6),
        (8,'修改品牌','brand/edit,brand/update',6),
        (9,'删除品牌','brand/delete',6),
    (10,'商品列表','goods/index',1),
        (11,'添加商品','goods/create,goods/insert',10),
        (12,'修改商品','goods/edit,goods/update',10),
        (13,'删除商品','goods/delete',10),
        (36,'AJAX获取分类','goods/ajax_get_cat',10),
(14,'管理员模块','',0),
    (15,'权限列表','privilege/index',14),
        (16,'添加权限','privilege/create,privilege/insert',15),
        (17,'修改权限','privilege/edit,privilege/update',15),
        (18,'删除权限','privilege/delete',15),
    (19,'角色列表','role/index',14),
        (20,'添加角色','role/create,role/insert',19),
        (21,'修改角色','role/edit,role/update',19),
        (22,'删除角色','role/delete',19),
    (23,'管理员列表','admin/index',14),
        (24,'添加管理员','admin/create,admin/insert',23),
        (25,'修改管理员','admin/edit,admin/update',23),
        (26,'删除管理员','admin/delete',23),
(27,'文章模块','',0),
    (28,'分类列表','Article_category/index',27),
        (29,'添加分类','article_category/create,article_category/insert',28),
        (30,'修改分类','article_category/edit,article_category/update',28),
        (31,'删除分类','article_category/delete',28),
    (32,'文章列表','article/index',27),
        (33,'添加文章','article/create,article/insert',32),
        (34,'修改文章','article/edit,article/update',32),
        (35,'删除文章','article/delete',32);

insert into role_privlege(pri_id,role_id) VALUES
(6,2),
(7,2),
(8,2),
(9,2),
(1,3),
(2,3),
(3,3),
(4,3),
(5,3),
(6,3),
(7,3),
(8,3),
(9,3);

insert into role(id,role_name) VALUES
(1,'超级管理员'),
(2,'品牌编辑'),
(3,'商品总监');

insert into admin_role(role_id,admin_id) VALUES
(1,1),
(3,2),
(2,3);

insert into admin(id,username,password) VALUES
(1,'root','21232f297a57a5a743894a0e4a801fc3'),
(2,'tom','21232f297a57a5a743894a0e4a801fc3'),

(3,'jack','21232f297a57a5a743894a0e4a801fc3'),
(4,'lilei','21232f297a57a5a743894a0e4a801fc3');


drop table if exists article_category;
create table article_category
(
    id int unsigned not null auto_increment comment 'ID',
    cat_name varchar(255) not null comment '分类名称',
    primary key (id)
)engine=InnoDB comment='文章分类表';

drop table if exists article;
create table article
(
    id int unsigned not null auto_increment comment 'ID',
    title varchar(255) not null comment '标题',
    content longtext comment '文章内容',
    created_at datetime not null default current_timestamp comment '发表时间',
    link varchar(255) comment '跳转的地址',
    article_category_id int unsigned not null comment '关联的分类ID',
    primary key (id)
)engine=InnoDB comment='文章表';

# 我是yinrui
