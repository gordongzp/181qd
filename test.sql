/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     2016/6/21 2:02:27                            */
/*==============================================================*/


drop table if exists cms_admin;

drop table if exists cms_admin_role;

drop table if exists cms_auth;

drop table if exists cms_hotspot;

drop table if exists cms_hotspot_category;

drop table if exists cms_menu;

drop table if exists cms_news;

drop table if exists cms_news_attachment;

drop table if exists cms_news_category;

drop table if exists cms_scene;

drop table if exists cms_scene_attachment;

drop table if exists cms_tour;

drop table if exists cms_tour_category;

/*==============================================================*/
/* Table: cms_admin                                             */
/*==============================================================*/
create table cms_admin
(
   admin_id             int(11) not null auto_increment,
   role_id              tinyint(3),
   last_login_ip        varchar(15) not null default '0.0.0.0',
   admin_name           varchar(15) not null,
   admin_password       varchar(32) not null,
   status               tinyint(1) default 0,
   add_time             varchar(13) not null,
   last_login_time      varchar(13),
   login_times          int(11),
   is_supper            tinyint(1),
   primary key (admin_id)
);

/*==============================================================*/
/* Table: cms_admin_role                                        */
/*==============================================================*/
create table cms_admin_role
(
   role_id              tinyint(3) not null auto_increment,
   role_name            varchar(50) not null,
   sort                 varchar(3) default '0',
   status               varchar(1) not null default '1',
   primary key (role_id)
);

/*==============================================================*/
/* Table: cms_auth                                              */
/*==============================================================*/
create table cms_auth
(
   role_id              tinyint(3),
   menu_id              smallint(6)
);

/*==============================================================*/
/* Table: cms_hotspot                                           */
/*==============================================================*/
create table cms_hotspot
(
   hotspot_id           int(10) not null auto_increment,
   cat_id               int(10),
   scene_id             int(10),
   title                varchar(200) not null,
   sort                 tinyint(6) not null default 0,
   status               tinyint(1) unsigned default 1,
   update_time          varchar(13),
   pic                  text,
   ath                  float(11) not null default 0,
   atv                  float(11) not null default 0,
   scale                float(11) not null default 1,
   goto_scene_id        int(10),
   goto_scene_hlookat   float(11) not null default 0,
   goto_scene_vlookat   float(11) not null default 0,
   goto_scene_fov       float(11) not null default 100,
   target               text,
   primary key (hotspot_id)
);

/*==============================================================*/
/* Table: cms_hotspot_category                                  */
/*==============================================================*/
create table cms_hotspot_category
(
   cat_id               int(10) not null auto_increment,
   cat_name             varchar(50) not null,
   sort                 tinyint(6) unsigned not null default 0,
   primary key (cat_id)
);

/*==============================================================*/
/* Table: cms_menu                                              */
/*==============================================================*/
create table cms_menu
(
   menu_id              smallint(6) not null auto_increment,
   menu_name            varchar(50) not null,
   pid                  smallint(6) not null,
   type                 tinyint(1) not null default 1,
   module_name          varchar(20) not null,
   action_name          varchar(20) not null,
   class_name           varchar(20),
   data                 varchar(120) not null,
   remark               varchar(255) not null,
   often                tinyint(1) not null default 0,
   sort                 tinyint(3) unsigned not null default 255,
   status               tinyint(1) not null default 1,
   primary key (menu_id)
);

/*==============================================================*/
/* Table: cms_news                                              */
/*==============================================================*/
create table cms_news
(
   news_id              int(10) not null auto_increment,
   cat_id               int(10),
   title                varchar(200) not null,
   summary              varchar(150),
   contents             text not null,
   sort                 tinyint(6) default 0,
   status               tinyint(1) unsigned default 1,
   update_time          varchar(13),
   source               varchar(20) default '一建',
   view_times           int(11) default 100,
   pic                  text,
   primary key (news_id)
);

/*==============================================================*/
/* Table: cms_news_attachment                                   */
/*==============================================================*/
create table cms_news_attachment
(
   atta_id              int(11) not null auto_increment,
   news_id              int(10),
   path                 text not null,
   primary key (atta_id)
);

/*==============================================================*/
/* Table: cms_news_category                                     */
/*==============================================================*/
create table cms_news_category
(
   cat_id               int(10) not null auto_increment,
   cat_name             varchar(50) not null,
   sort                 tinyint(6) unsigned not null default 0,
   primary key (cat_id)
);

/*==============================================================*/
/* Table: cms_scene                                             */
/*==============================================================*/
create table cms_scene
(
   scene_id             int(10) not null auto_increment,
   tour_id              int(10),
   title                varchar(200) not null,
   sort                 tinyint(6) unsigned not null,
   update_time          varchar(13),
   pic                  text not null,
   hlookat              float(11) not null default 0,
   vlookat              float(11) not null default 0,
   fov                  float(11) not null default 100,
   primary key (scene_id)
);

/*==============================================================*/
/* Table: cms_scene_attachment                                  */
/*==============================================================*/
create table cms_scene_attachment
(
   atta_id              int(11) not null auto_increment,
   scene_id             int(10),
   path                 text not null,
   primary key (atta_id)
);

/*==============================================================*/
/* Table: cms_tour                                              */
/*==============================================================*/
create table cms_tour
(
   tour_id              int(10) not null auto_increment,
   cat_id               int(10),
   admin_id             int(11),
   title                varchar(200) not null,
   summary              varchar(150),
   sort                 tinyint(6) default 0,
   status               tinyint(1) unsigned default 1,
   update_time          varchar(13),
   view_times           int(11) default 100,
   pic                  text,
   auto_rotate          float(11) not null default 0,
   primary key (tour_id)
);

/*==============================================================*/
/* Table: cms_tour_category                                     */
/*==============================================================*/
create table cms_tour_category
(
   cat_id               int(10) not null auto_increment,
   cat_name             varchar(50) not null,
   sort                 tinyint(6) unsigned not null default 0,
   primary key (cat_id)
);

alter table cms_admin add constraint FK_Reference_5 foreign key (role_id)
      references cms_admin_role (role_id) on delete restrict on update restrict;

alter table cms_auth add constraint FK_Reference_2 foreign key (role_id)
      references cms_admin_role (role_id) on delete restrict on update restrict;

alter table cms_auth add constraint FK_Reference_4 foreign key (menu_id)
      references cms_menu (menu_id) on delete restrict on update restrict;

alter table cms_hotspot add constraint FK_Reference_15 foreign key (cat_id)
      references cms_hotspot_category (cat_id) on delete restrict on update restrict;

alter table cms_hotspot add constraint FK_Reference_17 foreign key (scene_id)
      references cms_scene (scene_id) on delete restrict on update restrict;

alter table cms_news add constraint FK_Reference_13 foreign key (cat_id)
      references cms_news_category (cat_id) on delete restrict on update restrict;

alter table cms_news_attachment add constraint FK_Reference_12 foreign key (news_id)
      references cms_news (news_id) on delete restrict on update restrict;

alter table cms_scene add constraint FK_Reference_10 foreign key (tour_id)
      references cms_tour (tour_id) on delete restrict on update restrict;

alter table cms_scene_attachment add constraint FK_Reference_11 foreign key (scene_id)
      references cms_scene (scene_id) on delete restrict on update restrict;

alter table cms_tour add constraint FK_Reference_14 foreign key (cat_id)
      references cms_tour_category (cat_id) on delete restrict on update restrict;

alter table cms_tour add constraint FK_Reference_16 foreign key (admin_id)
      references cms_admin (admin_id) on delete restrict on update restrict;

