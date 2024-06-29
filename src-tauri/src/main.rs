// Prevents additional console window on Windows in release, DO NOT REMOVE!!
#![cfg_attr(not(debug_assertions), windows_subsystem = "windows")]

use std::sync::OnceLock;
use actix_web::web;
use actix_web::{middleware,App, HttpResponse, HttpServer};
use tauri::{Manager, Window};

static WINDOW: OnceLock<Window> = OnceLock::new();

#[derive(Clone, serde::Serialize)]
struct Payload {
  message: String,
}

fn main() {
    let app = tauri::Builder::default()
        .plugin(tauri_plugin_window_state::Builder::default().build())
        .setup(|app| {
            let window = app.get_window("main").unwrap();

            _ = WINDOW.set(window);

            /// This handler uses json extractor
            // async fn handle_get(item: web::Json<serde_json::Value>) -> HttpResponse {
            //     println!("GET: {:?}", &item);
            //     HttpResponse::Ok().json(item) // <- send response
            // }

            async fn handle_post(item: web::Json<serde_json::Value>) -> HttpResponse {
                // println!("POST: {:?}", &item);
                WINDOW.get()
                    .expect("Window is available")
                    .emit("post", Payload { message: item.to_string().into() })
                    .unwrap();
                HttpResponse::Ok().json(item) // <- send response
            }

            tauri::async_runtime::spawn(
                HttpServer::new(|| {
                    App::new()
                        // enable logger
                        .wrap(middleware::Logger::default())
                        // .route("/", web::get().to(handle_get))
                        .route("/", web::post().to(handle_post))
                })
                .bind(("0.0.0.0", 8383))
                .expect("Failed to bind address")
                .run(),
            );

            Ok(())
        })
        .build(tauri::generate_context!())
        .expect("error while running tauri application");

    app.run(|_, _| {})
}
