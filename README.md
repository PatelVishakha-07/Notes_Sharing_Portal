# Notes Sharing Portal

A web-based platform where users upload and share study notes — optionally with a YouTube link — with an admin moderation workflow, public/private visibility controls, and a trust-based system for managing user behavior.

## Overview

Sharing notes informally (scattered drives, chat groups) makes it hard to trust the quality of what's shared and gives no way to control who sees what. This portal solves that with three things working together: every upload goes through admin approval before it's visible, users choose whether their notes are public or restricted to people they share an access code with, and repeated low-quality or incorrect uploads are tracked per user so admins can act on a pattern rather than a single bad submission.

## Features

- **Note Uploads with Optional Video Link** — users upload notes and can attach a YouTube link alongside them
- **Admin Approval Workflow** — every upload is reviewed by an admin and approved or rejected before it's visible to others
- **Public / Private Visibility** — note owners choose whether a note is public or private; private notes are only accessible to others via a code shared by the owner
- **Rejection Tracking & Account Moderation** — each user's rejection count is visible to them, giving admins a clear signal to deactivate accounts that repeatedly upload incorrect or low-quality content
- **Search & Favorites** — users can search public notes and save them to a favorites list for quick access later
- **Subject & Category Management** — admins maintain the subjects and categories notes are organized under
- **Authentication** — separate access levels for regular users and admins

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel (PHP) |
| Frontend | Blade, CSS |
| Database | MySQL |

## Getting Started

### Prerequisites

- PHP and Composer installed
- Node.js and npm installed
- MySQL server running locally or remotely

### Setup

1. Clone the repository
   ```
   git clone https://github.com/PatelVishakha-07/Notes_Sharing_Portal.git
   ```
2. Install PHP dependencies
   ```
   composer install
   ```
3. Install JS dependencies and build assets
   ```
   npm install && npm run build
   ```
4. Copy `.env.example` to `.env` and set your database credentials
5. Generate the application key and run migrations
   ```
   php artisan key:generate
   php artisan migrate
   ```
6. Run the application
   ```
   php artisan serve
   ```

## How It Works

1. **Admins** set up the subjects and categories notes can be organized under
2. A **user** uploads a note, optionally attaching a YouTube link, and sets its visibility to public or private
3. The upload enters a **pending** state and is sent to the admin for review
4. The **admin** approves or rejects the note; rejections count against the uploading user, and that count is visible to the user
5. If a user accumulates too many rejections, indicating repeated incorrect or low-quality uploads, an **admin** can deactivate their account
6. Once approved, **public notes** are searchable and visible to all users, who can save any public note to their **favorites**
7. **Private notes** stay hidden from search and are only accessible to someone who has the **access code** shared by the note's owner

## Author

**Vishakha Patel** — [LinkedIn](https://www.linkedin.com/in/patelvishakha-tech)
